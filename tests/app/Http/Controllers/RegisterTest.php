<?php

namespace Tests\App\Http\Controllers;

use App\Mail\Register;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itRegistersHostnameAndSendsEmail(): void
    {
        Mail::fake();

        $this->postJson(route('register'), [
            'hostname' => 'foo',
            'ip' => '33.33.33.33',
            'email' => 'foo@vehikl.com',
            'expires_in' => '24',
        ])->assertSuccessful();

        $this->assertDatabaseHas('hostnames', [
            'name' => 'foo',
        ]);

        Mail::assertSent(Register::class);
    }

    /** @test */
    public function itCreatesExpiresAtWithNowPlusExpiresInDays(): void
    {
        Mail::fake();
        Carbon::setTestNow('now');
        $expiresInDays = 7;

        $this->postJson(route('register'), [
            'hostname' => 'foo',
            'ip' => '33.33.33.33',
            'email' => 'foo@vehikl.com',
            'expires_in' => $expiresInDays,
        ])->assertSuccessful();

        $this->assertDatabaseHas('hostnames', [
            'name' => 'foo',
            'expires_at' => Carbon::now()->addDays($expiresInDays)
        ]);
    }
}
