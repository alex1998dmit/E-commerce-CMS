<?php

use Illuminate\Database\Seeder;

class PhotosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for ($i = 1; $i <= 3; $i++) {
            DB::table('photos')->insert([
                'product_id' => 1,
                'path' => 'lotr' . $i . ".jpeg",
            ]);

            DB::table('photos')->insert([
                'product_id' => 2,
                'path' => 'ipad-pro' . $i . ".jpeg",
            ]);
        }

        DB::table('photos')->insert([
            'product_id' => 3,
            'path' => 'potatoes.jpeg',
        ]);
    }
}
