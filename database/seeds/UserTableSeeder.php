<?php

use App\Role;
use App\User;
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
        $role_user = Role::where('name', 'user')->first();
        $role_seller  = Role::where('name', 'seller')->first();
        $role_operator = Role::where('name', 'operator')->first();
        $role_admin = Role::where('name', 'admin')->first();

        $user = User::create([
            'name' => 'Pasha',
            'email' => 'pashaTest@gmail.com',
            'password' => bcrypt("adminadmin"),
        ]);

        $user->role()->attach($role_user);

        $seller = User::create([
            'name' => 'Tirion',
            'email' => 'lanisterSmall@gmail.com',
            'password' => bcrypt("adminadmin")
        ]);

        $seller->role()->attach($role_seller);

        $operator = User::create([
            'name' => 'Daenerys',
            'email' => 'dragonsMother@gmail.com',
            'password' => bcrypt("drakarisdrakaris")
        ]);

        $operator->role()->attach($role_operator);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt("drakarisdrakaris")
        ]);
        
        $admin->role()->attach($role_admin);
    }
}
