<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'category_id' => 1,
            'name' => 'Lord of the rings',
            'price' => 1000,
            'description' => 'Best book ever'
        ]);

        DB::table('products')->insert([
            'category_id' => 2,
            'name' => 'Ipad pro 2019',
            'price' => 65000,
            'description' => 'Good device for family'
        ]);

        DB::table('products')->insert([
            'category_id' => 3,
            'name' => 'Potatoes',
            'price' => 30,
            'description' => 'Because i can'
        ]);
    }
}
