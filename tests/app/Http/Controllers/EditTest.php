<?php

namespace Tests\App\Http\Controllers;

use Tests\TestCase;

class EditTest extends TestCase
{

    /** @test */
    public function itShowViewSuccessfully() : void
    {
        $this->get(route('edit'))
            ->assertSuccessful()
            ->assertViewIs('edit');
    }
}
