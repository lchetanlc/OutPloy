<?php

namespace App\Jobs;

use App\Mail\WebsiteRecoveredMail;
use App\Mail\WebsiteStatusMail;
use App\Models\Website;
use App\Models\WebsiteCheck;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckWebsiteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 15;

    
    public function __construct(
        public int $websiteId,
        public string $mode = 'monitor'
    ) {}

    public function handle(): void
    {
        $website = Website::with('client')->findOrFail($this->websiteId);
        $previousStatus = $website->last_status;

        $status = 'down';
        $httpCode = null;
        $responseMs = null;
        $error = null;

        $start = microtime(true);

        try {
            $res = Http::timeout(10)->get($website->url);
            $httpCode = $res->status();
            $status = ($httpCode >= 200 && $httpCode < 400) ? 'up' : 'down';
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            $status = 'down';
        }

        $responseMs = (int) round((microtime(true) - $start) * 1000);

        $check = WebsiteCheck::create([
            'website_id' => $website->id,
            'status' => $status,
            'http_code' => $httpCode,
            'response_ms' => $responseMs,
            'error' => $error,
            'checked_at' => now(),
        ]);

        $website->update([
            'last_status' => $status,
            'last_checked_at' => now(),
        ]);

        

        
        if ($this->mode === 'report') {
            Mail::to($website->client->email)->send(new WebsiteStatusMail($website, $check));
            Log::info('Report mail sent', ['website_id' => $website->id, 'status' => $status]);
            return;
        }

        

        
        if ($status === 'down' && $previousStatus === 'down') {
            Mail::to($website->client->email)->send(new WebsiteStatusMail($website, $check));
            Log::info('Down continuation mail sent', ['website_id' => $website->id]);
            return;
        }

        
        if ($status === 'down' && $previousStatus !== 'down') {
            Mail::to($website->client->email)->send(new WebsiteStatusMail($website, $check));
            Log::info('Down alert mail sent', ['website_id' => $website->id]);
            return;
        }

        
        if ($status === 'up' && $previousStatus === 'down') {
            Mail::to($website->client->email)->send(new WebsiteRecoveredMail($website, $check));
            Log::info('Recovery mail sent', ['website_id' => $website->id]);
            return;
        }

        
        Log::info('No mail needed (site still up)', [
            'website_id' => $website->id,
            'status' => $status,
        ]);
    }
}
