<?php

namespace App\Mail;

use App\Models\Website;
use App\Models\WebsiteCheck;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WebsiteStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Website $website,
        public WebsiteCheck $check
    ) {}

    public function build()
    {
        return $this->subject("{$this->website->url} is down!")
            ->markdown('emails.website_status');
    }
}
