<?php

namespace App\Mail;

use App\Hostname;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Register extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Hostname
     */
    private $subDomain;

    public function __construct(Hostname $subDomain)
    {
        $this->subDomain = $subDomain;
    }

    public function build(): self
    {
        return $this->from(config('mail.from.address'))
            ->markdown('emails.register', [
                'url' => route('activate', $this->subDomain->token),
            ]);
    }
}
