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
            'description' => 'Покупатель',
        ]);


        DB::table('roles')->insert([
            'name' => 'operator',
            'description' => 'Оператор',
        ]);

        DB::table('roles')->insert([
            'name' => 'admin',
            'description' => 'Администратор',
        ]);
    }
}
