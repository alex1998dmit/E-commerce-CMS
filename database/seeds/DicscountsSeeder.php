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
        $discount_diff = 5;
        for($i = 0; $i < 100;$i = $i + $discount_diff) {
            DB::table('discounts')->insert([
                'name' => 'Status with ' . $i . " discount",
                'discount' => $i,
                'description' => 'Lorem ipsum',
            ]);
        }
    }
}
