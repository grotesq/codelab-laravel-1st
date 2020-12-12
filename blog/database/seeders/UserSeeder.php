<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'email' => 'user@user.com',
            'password' => bcrypt( 'password' ),
            'name' => 'User',
        ]);
        \App\Models\User::factory()->times(9)->create();
    }
}
