<?php

namespace App\Console\Commands;

use App\Services\DatabaseBackupService;
use Illuminate\Console\Command;

class DatabaseBackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup {--restore= : Backup ID to restore}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or restore database backups';

    protected DatabaseBackupService $backupService;

    /**
     * Create a new command instance.
     */
    public function __construct(DatabaseBackupService $backupService)
    {
        parent::__construct();
        $this->backupService = $backupService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $restoreId = $this->option('restore');

        if ($restoreId) {
            return $this->restoreBackup($restoreId);
        }

        return $this->createBackup();
    }

    /**
     * Create a new backup.
     */
    protected function createBackup(): int
    {
        $this->info('Starting database backup...');
        $bar = $this->output->createProgressBar(3);
        
        $bar->start();
        $this->info('Creating backup record...');
        $bar->advance();

        try {
            // Use first user ID or create with ID 1 for CLI
            $userId = \App\Models\User::value('id') ?? 1;
            
            $this->info('Dumping database...');
            $bar->advance();
            
            $backup = $this->backupService->create($userId);
            
            $bar->finish();
            $this->newLine();
            
            $this->info("✓ Backup completed successfully!");
            $this->info("Filename: {$backup->filename}");
            $this->info("Size: {$backup->formatted_size}");

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $bar->finish();
            $this->newLine();
            
            $this->error("✗ Backup failed: {$e->getMessage()}");
            
            return Command::FAILURE;
        }
    }

    /**
     * Restore from a backup.
     */
    protected function restoreBackup(string $backupId): int
    {
        $this->warn("Restoring from backup ID: {$backupId}");
        $this->warn('WARNING: This will replace the current database!');
        
        if (!$this->confirm('Are you sure you want to continue?')) {
            $this->info('Restore cancelled.');
            return Command::FAILURE;
        }

        try {
            $backup = \App\Models\Backup::findOrFail($backupId);
            
            $this->info('Starting restore...');
            
            $this->backupService->restore($backup);
            
            $this->info("✓ Database restored successfully from: {$backup->filename}");
            $this->warn('Please clear your application cache if needed.');

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("✗ Restore failed: {$e->getMessage()}");
            return Command::FAILURE;
        }
    }
}
