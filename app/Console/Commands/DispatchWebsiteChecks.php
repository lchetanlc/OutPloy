<?php

namespace App\Console\Commands;

use App\Jobs\CheckWebsiteJob;
use App\Models\Website;
use Illuminate\Console\Command;

class DispatchWebsiteChecks extends Command
{
    protected $signature = 'monitor:dispatch-checks';
    protected $description = 'Dispatch uptime checks for all websites';

    public function handle(): int
    {
        \Log::info('Scheduler ran: monitor:dispatch-checks at '.now());

        Website::select('id')->chunkById(200, function ($chunk) {
            foreach ($chunk as $w) {
                CheckWebsiteJob::dispatch($w->id, 'monitor');
            }
        });

        $this->info('Dispatched website checks.');
        return self::SUCCESS;
    }
}
