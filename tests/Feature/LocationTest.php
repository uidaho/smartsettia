<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LocationTest extends TestCase
{
    /**
     * Tests if the database, locations table, and seed work properly.
     *
     * @return void
     */
    public function testDatabase()
    {
        // Make call to application...
        $this->assertDatabaseHas('locations', [
            'id' => '1'
        ]);
    }
}
