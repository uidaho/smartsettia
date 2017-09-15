<?php

use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // id name location_id
        factory(App\Location::class)->create([
            'name' => 'Functional Test Location Name',
            'site_id' => 1,
        ]);
    }
}
