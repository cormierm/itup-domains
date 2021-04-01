<?php

namespace Tests\App\Http\Controllers;

use App\Hostname;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itSendsUpdateEmail() : void
    {
        Mail::fake();
        Carbon::setTestNow('now');
        $hostname = factory(Hostname::class)->create();

        $data = [
            'hostname' => $hostname->name,
            'email' => $hostname->email,
            'ip' => '111.111.111.111',
            'expires_in' => 7,
        ];
        $this->post(route('update'), $data)
            ->assertSuccessful();

        $this->assertDatabaseHas('transactions', [
            'action' => 'update',
            'details' => json_encode([
                'hostname_id' => $hostname->id,
                'ip' => $data['ip'],
                'expires_at' => Carbon::now()->addDays($data['expires_in']),
            ])
        ]);

        Mail::assertSent(\App\Mail\Update::class);
    }

    /** @test */
    public function itHasValidationErrorIfHostnameAndEmailDoNotMatch() : void
    {
        $hostname = factory(Hostname::class)->create();

        $data = [
            'hostname' => $hostname->name,
            'email' => 'not@matching.email',
            'ip' => '111.111.111.111',
            'expires_in' => 7,
        ];
        $this->post(route('update'), $data)
            ->assertRedirect()
            ->assertSessionHasErrors('hostname', 'Hostname and email do not match our records.');
    }
}
