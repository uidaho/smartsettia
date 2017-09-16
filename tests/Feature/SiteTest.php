<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SiteTest extends TestCase
{
    /**
     * Tests if the database, sites table, and seed work properly.
     *
     * @return void
     */
    public function testDatabase()
    {
        // Make call to application...
        $this->assertDatabaseHas('sites', [
            'id' => '1'
        ]);
    }
}
