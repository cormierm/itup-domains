<?php

namespace Tests\App;

use App\Hostname;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class HostnameTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function itReturnsFullName(): void
    {
        Config::set('itup.domain', 'bar.com');

        $hostname = factory(Hostname::class)->create([
            'name' => 'foo',
        ]);

        $this->assertEquals('foo.bar.com', $hostname->fullName());
    }
}
