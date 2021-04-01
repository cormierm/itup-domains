<?php

namespace App\Jobs;

use App\Hostname;
use App\Mail\ActivationError;
use App\Transaction;
use Aws\Route53\Route53Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class UpdateRecordSet implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var array
     */
    private $details;

    public function __construct(Transaction $transaction)
    {

        $this->details = json_decode($transaction->details, true);
    }

    public function handle(Route53Client $route53Client) : void
    {

        $hostname = Hostname::query()->findOrFail($this->details['hostname_id']);

        try {
            $route53Client->changeResourceRecordSets([
                'HostedZoneId' => config('itup.hosted_zone_id'),
                'ChangeBatch' => [
                    'Comment' => 'Generated by ' . config('app.name'),
                    'Changes' => [
                        [
                            'Action' => 'UPSERT',
                            'ResourceRecordSet' => [
                                'Name' => $hostname->fullName() . '.',
                                'TTL' => 300,
                                'Type' => 'A',
                                'ResourceRecords' => [
                                    [
                                        'Value' => $this->details['ip'],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]);

            $hostname->update(['ip' => $this->details['ip']]);
        } catch (Throwable $e) {
            Log::error('Could not update recordset' . $hostname->name, [
                'hostname' => $hostname,
                'exception' => $e,
            ]);

            Mail::to($hostname->email)->send(new ActivationError($hostname));
        }
    }
}
