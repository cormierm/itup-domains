<?php

namespace Tests\App;

use App\Hostname;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class HostnameTest extends TestCase
{
    /** @test */
    public function itReturnsFullName(): void
    {
        Config::set('itup.domain', 'bar.com');

        $hostname = factory(Hostname::class)->make([
            'name' => 'foo',
        ]);

        $this->assertEquals('foo.bar.com', $hostname->fullName());
    }

    /** @test */
    public function itReturnsTrueExpiresAtInPast(): void
    {
        Carbon::setTestNow('now');
        $hostname = factory(Hostname::class)->make([
            'expires_at' => Carbon::now()->subMinute(),
        ]);

        $this->assertTrue($hostname->isExpired());
    }

    /** @test */
    public function itReturnsFalseExpiresAtInFuture(): void
    {
        Carbon::setTestNow('now');
        $hostname = factory(Hostname::class)->make([
            'expires_at' => Carbon::now()->addHour(),
        ]);

        $this->assertFalse($hostname->isExpired());
    }
}
