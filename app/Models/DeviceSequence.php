<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DeviceSequence extends Model
{
    use HasFactory;

    protected $fillable = [
        'sequence_name',
        'next_value',
    ];

    /**
     * Atomically get the next sequence number(s) and increment the counter.
     *
     * @param  string  $sequenceName  The name of the sequence (e.g., 'device_number')
     * @param  int  $count  How many numbers to reserve (default: 1)
     * @return int The starting number for this reservation
     *
     * @throws \RuntimeException if sequence not found
     */
    public static function getNext(string $sequenceName = 'device_number', int $count = 1): int
    {
        return DB::transaction(function () use ($sequenceName, $count) {
            // Lock the row to prevent concurrent access
            $sequence = self::where('sequence_name', $sequenceName)
                ->lockForUpdate()
                ->first();

            if (! $sequence) {
                throw new \RuntimeException("Sequence '{$sequenceName}' not found");
            }

            // Get current value
            $startValue = (int) $sequence->next_value;

            // Increment for next caller
            $sequence->next_value += $count;
            $sequence->save();

            return $startValue;
        });
    }
}
