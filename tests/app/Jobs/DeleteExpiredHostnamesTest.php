<?php

namespace Tests\App\Jobs;

use App\Hostname;
use App\Jobs\DeleteExpiredHostnames;
use App\Jobs\DeleteRecordSet;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteExpiredHostnamesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itDispatchesJobToDeleteExpiredHostnamesOlderThanWeek(): void
    {
        factory(Hostname::class)->create([
            'expires_at' => Carbon::now()->subDays(8),
        ]);
        $this->expectsJobs(DeleteRecordSet::class);

        (new DeleteExpiredHostnames)->handle();
    }

    /** @test */
    public function itDoesNotDispatchJobNonExpiredHostnames(): void
    {
        factory(Hostname::class)->create([
            'expires_at' => Carbon::now()->addDay(),
        ]);
        $this->doesntExpectJobs(DeleteRecordSet::class);
    }
}
