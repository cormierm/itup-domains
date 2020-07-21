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
    public function itRegistersSubDomainAndSendsEmail(): void
    {
        Mail::fake();

        $this->postJson(route('register'), [
            'sub_domain' => 'foo',
            'ip' => '33.33.33.33',
            'email' => 'foo@bar.com'
        ])->assertSuccessful();

        $this->assertDatabaseHas('sub_domains', [
            'name' => 'foo',
        ]);

        Mail::assertSent(Register::class);
    }
}
