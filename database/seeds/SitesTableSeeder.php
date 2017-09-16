<?php

use Illuminate\Database\Seeder;

class SitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // id name
        factory(App\Site::class)->create([
            'name' => 'Functional Test Site Name',
        ]);
    }
}
