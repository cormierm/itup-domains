<?php

namespace App\Mail;

use App\Hostname;
use App\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Update extends Mailable
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
        $changes = json_decode($this->transaction->details, true);
        $hostname = Hostname::query()->find($changes['hostname_id']);

        return $this->from(config('mail.from.address'))
            ->subject('Activate your hostname changes: ' . $hostname->fullName())
            ->markdown('emails.update', [
                'url' => route('confirm.update', $this->transaction->token),
                'hostname' => $hostname,
                'changes' => $changes,
            ]);
    }
}
