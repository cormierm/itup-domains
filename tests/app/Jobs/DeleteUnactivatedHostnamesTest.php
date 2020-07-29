<?php

namespace Tests\App\Jobs;

use App\Hostname;
use App\Jobs\DeleteUnactivatedHostnames;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteUnactivatedHostnamesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itDeletesUnverifiedHostnames(): void
    {
        $unverifiedHostname = factory(Hostname::class)->create([
            'verified_at' => null,
            'deleted_at' => null,
            'created_at' => Carbon::now()->subDays(2),
        ]);

        DeleteUnactivatedHostnames::dispatch();

        $this->assertNotNull($unverifiedHostname->fresh()->deleted_at);
    }

    /** @test */
    public function itDoesNotDeleteVerifiedHostname(): void
    {
        $verifiedHostname = factory(Hostname::class)->create([
            'verified_at' => Carbon::now(),
            'deleted_at' => null,
        ]);

        DeleteUnactivatedHostnames::dispatch();

        $this->assertNull($verifiedHostname->fresh()->deleted_at);
    }

    /** @test */
    public function itDoesNotDeleteHostnameLessThanDayOld(): void
    {
        $hostname = factory(Hostname::class)->create([
            'verified_at' => null,
            'deleted_at' => null,
            'created_at' => Carbon::now(),
        ]);

        DeleteUnactivatedHostnames::dispatch();

        $this->assertNull($hostname->fresh()->deleted_at);
    }
}
