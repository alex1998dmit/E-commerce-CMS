<?php

use Illuminate\Database\Seeder;
use App\Category;

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
            'name' => 'Книги',
            'parent_id' => 0,
        ]);

        DB::table('categories')->insert([
            'name' => 'Электроника',
            'parent_id' => 0,
        ]);

        DB::table('categories')->insert([
            'name' => 'Бытовая техника',
            'parent_id' => 0,
        ]);
    }
}
