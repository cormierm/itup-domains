<?php

namespace App\Mail;

use App\Hostname;
use App\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Renew extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Transaction
     */
    private $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function build(): self
    {

        return $this->from(config('mail.from.address'))
            ->subject('Activate your hostname changes: ' . $this->transaction->hostname->fullName())
            ->markdown('emails.renew', [
                'url' => route('edit', ['hostname' => $this->transaction->hostname->name]),
                'hostname' => $this->transaction->hostname,
            ]);
    }
}
