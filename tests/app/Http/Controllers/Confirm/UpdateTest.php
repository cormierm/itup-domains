<?php

namespace Tests\App\Http\Controllers\Confirm;

use App\Hostname;
use App\Jobs\UpdateRecordSet;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itWillUpdateExpiresAt() : void
    {
        Carbon::setTestNow('now');
        $hostname = factory(Hostname::class)->create();
        $transaction = factory(Transaction::class)->create([
            'hostname_id' => $hostname->id,
            'details' => json_encode([
                'hostname_id' => $hostname->id,
                'ip' => $hostname->ip,
                'expires_at' => Carbon::now()->addMonth(),
            ])
        ]);

        $this->get(route('confirm.update', ['token' => $transaction->token]))
            ->assertRedirect(route('home'))
            ->assertSessionHas('alert', [
                'type' => 'success',
                'text' => 'Successfully applied changes to hostname!',
            ]);

        $this->assertEquals(Carbon::now()->addMonth(), $hostname->fresh()->expires_at);
    }

    /** @test */
    public function itDispatchesJobToUpdateIpIfDifferent() : void
    {
        $this->expectsJobs(UpdateRecordSet::class);

        Carbon::setTestNow('now');
        $hostname = factory(Hostname::class)->create([
            'ip' => '11.11.11.11',
        ]);
        $newIp = '12.12.12.12';
        $transaction = factory(Transaction::class)->create([
            'hostname_id' => $hostname->id,
            'details' => json_encode([
                'hostname_id' => $hostname->id,
                'ip' => $newIp,
                'expires_at' => Carbon::now()->addMonth(),
            ])
        ]);

        $this->get(route('confirm.update', ['token' => $transaction->token]))
            ->assertRedirect(route('home'))
            ->assertSessionHas('alert', [
                'type' => 'success',
                'text' => 'Successfully applied changes to hostname!',
            ]);
    }


    /** @test */
    public function itWillRejectTransactionsOlderThenADay() : void
    {
        Carbon::setTestNow('now');
        $transaction = factory(Transaction::class)->create([
            'hostname_id' => 1,
            'details' => '',
            'created_at' => Carbon::now()->subWeek()
        ]);

        $this->get(route('confirm.update', ['token' => $transaction->token]))
            ->assertNotFound();
    }
}
