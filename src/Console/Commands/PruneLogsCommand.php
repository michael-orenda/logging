<?php

namespace MichaelOrenda\Logging\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PruneLogsCommand extends Command
{
    protected $signature = 'logging:prune
                            {--days= : Override retention days}
                            {--activity : Only prune activity logs}
                            {--security : Only prune security logs}
                            {--error : Only prune error logs}';

    protected $description = 'Prune old logs according to retention policy';

    public function handle()
    {
        $tables = [
            'activity_logs' => config('logging.retention_days.activity'),
            'security_logs' => config('logging.retention_days.security'),
            'error_logs'    => config('logging.retention_days.error'),
        ];

        // Apply flags
        if ($this->option('activity')) {
            $tables = array_intersect_key($tables, ['activity_logs' => true]);
        }

        if ($this->option('security')) {
            $tables = array_intersect_key($tables, ['security_logs' => true]);
        }

        if ($this->option('error')) {
            $tables = array_intersect_key($tables, ['error_logs' => true]);
        }

        // Custom days override
        $overrideDays = $this->option('days');

        foreach ($tables as $table => $days) {

            $daysToUse = $overrideDays ?: $days;

            $cutoff = Carbon::now()->subDays($daysToUse);

            $deleted = DB::table($table)
                ->where('created_at', '<', $cutoff)
                ->delete();

            $this->info("Pruned {$deleted} rows from {$table} (older than {$daysToUse} days)");
        }

        return Command::SUCCESS;
    }
}
