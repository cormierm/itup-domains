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
        $hostname = 'foobar';

        $this->postJson(route('check'), ['hostname' => $hostname])
            ->assertSuccessful()
            ->assertJson([
                'message' => "Congrats, {$hostname}.itup.ca is available!",
            ]);
    }

    /** @test */
    public function itReturnsSuccessfulHostnameIsSoftDeleted(): void
    {
        $hostname = factory(Hostname::class)->create([
            'name' => 'foobar',
            'deleted_at' => Carbon::now()
        ]);

        $this->postJson(route('check'), ['hostname' => $hostname->name])
            ->assertSuccessful()
            ->assertJson([
                'message' => "Congrats, {$hostname->name}.itup.ca is available!",
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
