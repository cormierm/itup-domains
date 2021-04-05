<?php

namespace Tests\App\Jobs;

use App\Hostname;
use App\Jobs\SendMailForExpiredHostnames;
use App\Mail\Renew;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SendMailForExpiredHostnamesTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function itCanSendMailAndCreateTransactionForExpiredHostname() : void
    {

        Mail::fake();

        $hostname = factory(Hostname::class)->create([
            'expires_at' => Carbon::now()->subDay(),
        ]);

        $job = new SendMailForExpiredHostnames;
        $job->handle();

        $this->assertDatabaseHas('transactions', [
            'hostname_id' => $hostname->id,
            'action' => 'renew',
        ]);

        Mail::assertSent(Renew::class);
    }

    /** @test */
    public function itDoesNotCreateTransactionOrSendMailForNonExpiredHostnames() : void
    {

        Mail::fake();

        $hostname = factory(Hostname::class)->create([
            'expires_at' => Carbon::now()->addDay(),
        ]);

        $job = new SendMailForExpiredHostnames;
        $job->handle();

        $this->assertDatabaseMissing('transactions', [
            'hostname_id' => $hostname->id,
            'action' => 'renew',
        ]);

        Mail::assertNotSent(Renew::class);
    }

    /** @test */
    public function itDoesNotSendMailForHostnamesWithRenewTransaction() : void
    {

        Mail::fake();

        $hostname = factory(Hostname::class)->create([
            'expires_at' => Carbon::now()->addDay(),
        ]);
        factory(Transaction::class)->create([
            'hostname_id' => $hostname->id,
            'action' => Transaction::ACTION_RENEW,
        ]);

        $job = new SendMailForExpiredHostnames;
        $job->handle();

        Mail::assertNotSent(Renew::class);
    }
}
