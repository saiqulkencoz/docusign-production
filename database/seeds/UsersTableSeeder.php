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
        \App\User::create([
            'nama'	=> 'Super Admin',
            'nik'	=> 'root',
            'role'	=> 'root',
            'password'	=> bcrypt('rahasia')
        ]);
    }
}
