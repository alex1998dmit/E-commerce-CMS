<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OperatorsCredentials extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 2; $i <= 4; $i++ ) {
            User::create([
                'name' => 'Опрератор ' . $i,
                'email' => 'operator' . $i . '@nady.shop',
                'password' => bcrypt('r7O318oJBD' . $i . 'operator'),
                'verification_token' => Str::random(32),
            ]);
        }
    }
}
