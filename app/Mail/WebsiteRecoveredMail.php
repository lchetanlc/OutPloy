<?php

namespace App\Mail;

use App\Models\Website;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WebsiteRecoveredMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Website $website) {}

    public function build()
    {
        return $this->subject("✅ {$this->website->url} is recovered!")
            ->view('emails.website-recovered');
    }
}
