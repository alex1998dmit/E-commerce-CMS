<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Alexander',
            'email' => 'sasha1998dmitalex@gmail.com',
            'password' => bcrypt("adminadmin")
        ]);

        DB::table('users')->insert([
            'name' => 'Pasha',
            'email' => 'pashaTest@gmail.com',
            'password' => bcrypt("adminadmin")
        ]);

        DB::table('users')->insert([
            'name' => 'Tirion',
            'email' => 'lanisterSmall@gmail.com',
            'password' => bcrypt("adminadmin")
        ]);

        DB::table('users')->insert([
            'name' => 'Daenerys',
            'email' => 'dragonsMother@gmail.com',
            'password' => bcrypt("drakarisdrakaris")
        ]);
    }
}
