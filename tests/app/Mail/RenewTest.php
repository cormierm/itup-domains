<?php

namespace Tests\App\Mail;

use App\Mail\Renew;
use App\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RenewTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function itCanRenderMail() : void
    {

        $transaction = factory(Transaction::class)->create();

        $mail = (new Renew($transaction));
        $mail->assertSeeInText('Your hostname is expired.');
        $mail->assertSeeInText($transaction->hostname->name);
        $mail->assertSeeInHtml(route('edit', ['hostname' => $transaction->hostname->name]));
    }
}
