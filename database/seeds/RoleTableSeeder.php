<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'user',
            'description' => 'Can see products, add to  wishList/shopingCart',
        ]);

        DB::table('roles')->insert([
            'name' => 'seller',
            'description' => 'Inherit users privileages, also can add products and have access for clients admin',
        ]);

        DB::table('roles')->insert([
            'name' => 'operator',
            'description' => 'Have access to server admin',
        ]);

        DB::table('roles')->insert([
            'name' => 'admin',
            'description' => 'GOD',
        ]);
    }
}
