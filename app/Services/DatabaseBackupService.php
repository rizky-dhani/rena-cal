<?php

namespace App\Services;

use App\Models\Backup;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DatabaseBackupService
{
    protected $disk = 'local';

    protected $backupPath = 'backups';

    /**
     * Create a new database backup.
     */
    public function create(int $userId): Backup
    {
        $backup = Backup::create([
            'filename' => $this->generateFilename(),
            'status' => 'pending',
            'created_by' => $userId,
        ]);

        try {
            $fullPath = $this->getFullPath($backup->filename);

            // Get database credentials
            $config = config('database.connections.'.config('database.default'));

            // Build mysqldump command
            $command = $this->buildDumpCommand($config, $fullPath);

            // Execute the backup
            $result = Process::timeout(300)->run($command);

            if ($result->failed()) {
                throw new \RuntimeException('Backup failed: '.$result->errorOutput());
            }

            // Get file size
            $fileSize = Storage::disk($this->disk)->size($this->backupPath.'/'.$backup->filename);

            // Update backup record
            $backup->update([
                'status' => 'completed',
                'file_size' => $fileSize,
            ]);

            Log::info('Database backup created successfully', [
                'backup_id' => $backup->id,
                'filename' => $backup->filename,
                'size' => $fileSize,
            ]);

        } catch (\Exception $e) {
            $backup->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            Log::error('Database backup failed', [
                'backup_id' => $backup->id,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }

        return $backup;
    }

    /**
     * Restore database from a backup file.
     */
    public function restore(Backup $backup): bool
    {
        if (! $backup->fileExists()) {
            throw new \RuntimeException('Backup file not found on disk');
        }

        if ($backup->status !== 'completed') {
            throw new \RuntimeException('Cannot restore a backup that is not completed successfully');
        }

        try {
            $fullPath = $this->getFullPath($backup->filename);
            $config = config('database.connections.'.config('database.default'));

            // Build restore command
            $command = $this->buildRestoreCommand($config, $fullPath);

            // Execute the restore
            $result = Process::timeout(600)->run($command);

            if ($result->failed()) {
                throw new \RuntimeException('Restore failed: '.$result->errorOutput());
            }

            Log::info('Database restored from backup', [
                'backup_id' => $backup->id,
                'filename' => $backup->filename,
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Database restore failed', [
                'backup_id' => $backup->id,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Download a backup file.
     */
    public function download(Backup $backup): StreamedResponse
    {
        if (! $backup->fileExists()) {
            abort(404, 'Backup file not found');
        }

        return Storage::disk($this->disk)->download($this->backupPath.'/'.$backup->filename);
    }

    /**
     * Delete a backup file and its record.
     */
    public function delete(Backup $backup): bool
    {
        // Delete file from disk
        if ($backup->fileExists()) {
            Storage::disk($this->disk)->delete($this->backupPath.'/'.$backup->filename);
        }

        // Delete record
        return $backup->delete();
    }

    /**
     * Get all backups list.
     */
    public function getList()
    {
        return Backup::with('creator')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
    }

    /**
     * Get disk usage statistics.
     */
    public function getDiskUsage(): array
    {
        $files = Storage::disk($this->disk)->files($this->backupPath);
        $totalSize = 0;
        $count = count($files);

        foreach ($files as $file) {
            $totalSize += Storage::disk($this->disk)->size($file);
        }

        return [
            'count' => $count,
            'total_size' => $totalSize,
            'formatted_size' => $this->formatBytes($totalSize),
        ];
    }

    /**
     * Generate unique filename.
     */
    protected function generateFilename(): string
    {
        return 'db_backup_'.now()->format('Y_m_d_His').'.sql.gz';
    }

    /**
     * Get full path for backup file.
     */
    protected function getFullPath(string $filename): string
    {
        return Storage::disk($this->disk)->path($this->backupPath.'/'.$filename);
    }

    /**
     * Build mysqldump command.
     */
    protected function buildDumpCommand(array $config, string $outputPath): string
    {
        // Ensure backup directory exists
        if (! Storage::disk($this->disk)->exists($this->backupPath)) {
            Storage::disk($this->disk)->makeDirectory($this->backupPath);
        }

        $host = $config['host'] ?? '127.0.0.1';
        $port = $config['port'] ?? '3306';
        $database = $config['database'];
        $username = $config['username'];
        $password = $config['password'];

        // Build command with gzip compression
        $command = sprintf(
            'mysqldump --host=%s --port=%s --user=%s --password=%s --single-transaction --quick --lock-tables=false %s | gzip > %s',
            escapeshellarg($host),
            escapeshellarg($port),
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($database),
            escapeshellarg($outputPath)
        );

        return $command;
    }

    /**
     * Build mysql restore command.
     */
    protected function buildRestoreCommand(array $config, string $inputPath): string
    {
        $host = $config['host'] ?? '127.0.0.1';
        $port = $config['port'] ?? '3306';
        $database = $config['database'];
        $username = $config['username'];
        $password = $config['password'];

        // Decompress and restore
        $command = sprintf(
            'gunzip < %s | mysql --host=%s --port=%s --user=%s --password=%s %s',
            escapeshellarg($inputPath),
            escapeshellarg($host),
            escapeshellarg($port),
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($database)
        );

        return $command;
    }

    /**
     * Format bytes to human-readable.
     */
    protected function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $bytes;
        $unit = 0;

        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }

        return round($size, 2).' '.$units[$unit];
    }
}
