<?php

use App\Http\Controllers\API\V1\OrderStatuses;
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
        $this->call(DicscountsSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(OrderStatuses::class);
    }
}
