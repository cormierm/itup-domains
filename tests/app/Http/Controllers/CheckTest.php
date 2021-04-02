<?php

namespace Tests\App\Http\Controllers;

use App\Hostname;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itReturnsSuccessfulWhenHostnameIsAvailable(): void
    {
        $domain = 'example.com';
        $hostname = 'foobar';
        config()->set('itup.domain', $domain);

        $this->postJson(route('check'), ['hostname' => $hostname])
            ->assertSuccessful()
            ->assertJson([
                'message' => sprintf("Congrats, %s.%s is available!", $hostname, $domain),
            ]);
    }

    /** @test */
    public function itReturnsSuccessfulHostnameIsSoftDeleted(): void
    {
        $domain = 'example.com';
        config()->set('itup.domain', $domain);
        $hostname = factory(Hostname::class)->create([
            'name' => 'foobar',
            'deleted_at' => Carbon::now()
        ]);

        $this->postJson(route('check'), ['hostname' => $hostname->name])
            ->assertSuccessful()
            ->assertJson([
                'message' => sprintf("Congrats, %s.%s is available!", $hostname->name, $domain),
            ]);
    }

    /** @test */
    public function itReturnsErrorForUnavailableHostnames(): void
    {
        $hostname = factory(Hostname::class)->create([
            'name' => 'foobar',
        ]);

        $this->postJson(route('check'), ['hostname' => $hostname->name])
            ->assertStatus(422)
            ->assertJsonValidationErrors('hostname');
    }
}
