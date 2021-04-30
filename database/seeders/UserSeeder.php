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
        User::create([
            'first_name' => 'Bokele wakiza',
            'Last_name' => 'Franck',
            'is_staff' => true,
            'is_superuser' => true,
            'email' => 'bwakiza@gmail.com',
            'password' => bcrypt('Bokele@02'),

        ]);
    }
}
