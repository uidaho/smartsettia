<?php

use Illuminate\Database\Seeder;

class DevicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // id name location_id
        factory(App\Device::class)->create([
            'name' => 'Functional Test Device Name',
            'location_id' => 1,
        ]);

        factory(App\Device::class, 50)->create([
            'location_id' => 1,
        ]);
    }
}
