<?php

namespace Tests\App\Http\Controllers;

use App\Mail\Register;
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
            'email' => 'foo@vehikl.com'
        ])->assertSuccessful();

        $this->assertDatabaseHas('hostnames', [
            'name' => 'foo',
        ]);

        Mail::assertSent(Register::class);
    }
}
