<?php

namespace Database\Seeders;

use App\Models\User;
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
        $user = User::create([
            'first_name' => 'mohamed',
            'last_name' => 'fawzy',
            'email' => 'mrrmohamedfawzy@gmail.com',
            'password' => bcrypt('00000000'),
        ]);
        $user->attachRole('super_admin');
    }
}
