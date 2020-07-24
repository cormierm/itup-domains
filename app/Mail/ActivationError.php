<?php

namespace App\Mail;

use App\Hostname;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActivationError extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Hostname
     */
    private $hostname;

    public function __construct(Hostname $hostname)
    {
        $this->hostname = $hostname;
    }

    public function build(): self
    {
        return $this->from(config('mail.from.address'))
            ->subject('Error activating your hostname: ' . $this->hostname->fullName())
            ->markdown('emails.activation-error', [
                'domain' => $this->hostname->fullName()
            ]);
    }
}
