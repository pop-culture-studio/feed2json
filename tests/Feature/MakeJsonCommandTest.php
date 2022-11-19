<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MakeJsonCommandTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testMakeJsonCommand()
    {
        Storage::fake();

        $this->artisan('feed:json')
             ->assertExitCode(0);

        Storage::assertExists('note_pcs_miraizu.json');
    }
}
