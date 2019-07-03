<?php

use Illuminate\Database\Seeder;

class RequisitesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('requisites')->insert([
            'title' => 'Сбербанк',
            'requisite' => '4253 5431 1235 3213',
        ]);

        DB::table('requisites')->insert([
            'title' => 'Авангард',
            'requisite' => '4251 4311 0000 1111',
            'description' => 'Лучше скидывать после полуночи',
        ]);
    }
}
