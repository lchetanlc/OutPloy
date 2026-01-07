<?php

namespace App\Console\Commands;

use App\Jobs\CheckWebsiteJob;
use App\Models\Website;
use Illuminate\Console\Command;

class MonitorSendReport extends Command
{
    protected $signature = 'monitor:send-report';
    protected $description = 'Send current status report email for all websites (report mode)';

    public function handle(): int
    {
        Website::query()->chunkById(200, function ($websites) {
            foreach ($websites as $website) {
                CheckWebsiteJob::dispatch($website->id, 'report');
            }
        });

        $this->info('Dispatched checks (report).');
        return self::SUCCESS;
    }
}
