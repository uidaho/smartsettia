<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create([
            'email' => 'superawesome@example.com',
        ]);

        factory(App\User::class, 50)->create();

        // factory(App\User::class, 50)->create()->each(function ($u) {
        //     $u->group()->save(factory(App\Group::class)->make());
        // });
    }
}
