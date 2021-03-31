<?php

namespace Tests\App\Http\Controllers;

use Tests\TestCase;

class EditTest extends TestCase
{

    /** @test */
    public function itShowViewSuccessfully() : void
    {

        $hostname = 'hello';
        $this->get(route('edit', $hostname))
            ->assertSuccessful()
            ->assertViewIs('edit')
            ->assertViewHas('hostname', $hostname);
    }
}
