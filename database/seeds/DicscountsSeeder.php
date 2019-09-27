<?php

use Illuminate\Database\Seeder;

class DicscountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('discounts')->insert([
            'name' => `Обычный пользователь`,
            'discount' => 0,
            'description' => 'Базовая категория для новых пользователей',
        ]);
    }
}
