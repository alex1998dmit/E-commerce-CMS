<?php

use Illuminate\Database\Seeder;

class OrdersStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_statuses')->insert([
            'name' => 'Ожидается оплата',
            'description' => 'Тестовое описание',
        ]);

        DB::table('order_statuses')->insert([
            'name' => 'Оплата отправлена пользователем',
            'description' => 'Тестовое описание',
        ]) ;

        DB::table('order_statuses')->insert([
            'name' => 'Оплата подтверждена оператором',
            'description' => 'Тестовое описание',
        ]);

        DB::table('order_statuses')->insert([
            'name' => 'Заказ собирается',
            'description' => 'Тестовое описание',
        ]);

        DB::table('order_statuses')->insert([
            'name' => 'Заказ отправлен',
            'description' => 'Тестовое описание',
        ]);

        DB::table('order_statuses')->insert([
            'name' => 'Ожидается получение',
            'description' => 'Тестовое описание',
        ]);

        DB::table('order_statuses')->insert([
            'name' => 'Заказ получен',
            'description' => 'Тестовое описание',
        ]);

        DB::table('order_statuses')->insert([
           'name' => 'Заказ отменен',
           'description' => 'Пользователь отменил заказ'
        ]);
    }
}
