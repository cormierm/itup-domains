<?php

namespace App\Mail;

use App\SubDomain;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Register extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var SubDomain
     */
    private $subDomain;

    public function __construct(SubDomain $subDomain)
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
