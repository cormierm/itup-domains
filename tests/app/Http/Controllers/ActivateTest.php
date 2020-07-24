<?php

namespace Tests\App\Http\Controllers;

use App\Hostname;
use App\Jobs\CreateRecordSet;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itWillReturnErrorIfTokenDoesNotExist(): void
    {

        $this->getJson(route('activate', 'invalid-token-uuid'))
            ->assertViewIs('home')
            ->assertViewHas('alert', [
                'type' => 'error',
                'text' => 'There was a problem activating. This hostname may have been already activated.'
            ]);
    }

    /** @test */
    public function itWillNotActivateExpired(): void
    {

        $hostname = factory(Hostname::class)->create([
            'created_at' => Carbon::now()->subDays(2),
            'verified_at' => null,
        ]);

        $this->getJson(route('activate', $hostname->token))
            ->assertViewIs('home')
            ->assertViewHas('alert', [
                'type' => 'error',
                'text' => 'There was a problem activating. This activation has expired. Please try registering again'
            ]);
    }

    /** @test */
    public function itWillActivateNonVerifiedHostnameWithValidToken(): void
    {

        $this->expectsJobs(CreateRecordSet::class);

        $hostname = factory(Hostname::class)->create([
            'verified_at' => null,
        ]);

        $this->getJson(route('activate', $hostname->token))
            ->assertViewIs('home')
            ->assertViewHas('alert', [
                'type' => 'success',
                'text' => 'Successfully activated hostname!'
            ]);

        $this->assertNotNull($hostname->fresh()->verified_at);
    }
}
