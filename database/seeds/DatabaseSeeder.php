<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RequisitesSeeder::class);
        $this->call(DicscountsSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
        // $this->call(CategoriesTableSeeder::class);
        // $this->call(ProductsTableSeeder::class);
        $this->call(OauthClientsSeeder::class);
        // $this->call(OrdersSeeder::class);
        // $this->call(PhotosSeeder::class);
    }
}
