<?php

use Illuminate\Database\Seeder;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = App\User::where('email', 'sasha1998dmitalex@gmail.com')->first();
        $products = App\Product::all();
        $amount = 10;
        //
        foreach ($products as $product) {
            DB::table('orders')->insert([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'amount' => $amount,
                'sum' => $amount * $product->price,
            ]);
        }

    }
}
