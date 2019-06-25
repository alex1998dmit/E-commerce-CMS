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
            'parent_id' => 0,
        ]);

        DB::table('categories')->insert([
            'name' => 'Electronics',
            'parent_id' => 0,
        ]);

        DB::table('categories')->insert([
            'name' => 'Food',
            'parent_id' => 0,
        ]);
    }
}
