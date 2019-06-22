<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'Books',
        ]);

        DB::table('categories')->insert([
            'name' => 'Electronics',
        ]);

        DB::table('categories')->insert([
            'name' => 'Food',
        ]);
    }
}
