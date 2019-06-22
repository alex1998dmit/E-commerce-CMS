<?php
//  NOT SAFE FOR PRODUCTION, ONLY FOR TESTING
use Illuminate\Database\Seeder;

class OauthClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->insert([
            'user_id' => null,
            'name' => 'Laravel Personal Access Client',
            'secret' => 'nxu17WXZqxgCeSQmKxL3YGd40Fw48s44eIDZAgXR',
            'redirect' => 'http://localhost',
            'personal_access_client' => 1,
            'password_client' => 0,
            'revoked' => 0,
        ]);

        DB::table('oauth_clients')->insert([
            'user_id' => null,
            'name' => 'Laravel Password Grant Client',
            'secret' => 'WhYqHBDCWfGGecC4XcRc6yur09AJxxCvn3FiPJJT',
            'redirect' => 'http://localhost',
            'personal_access_client' => 0,
            'password_client' => 1,
            'revoked' => 0,
        ]);
    }
}
