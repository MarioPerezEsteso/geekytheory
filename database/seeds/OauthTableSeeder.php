<?php

use Illuminate\Database\Seeder;
use Laravel\Passport\ClientRepository;

class OauthTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPersonalAccessClient(
            null, 'Test Personal Access Client', 'http://localhost'
        );
        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => $client->id,
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);
        \Illuminate\Support\Facades\Config::set('passport.client.id', $client->id);
        \Illuminate\Support\Facades\Config::set('passport.client.secret', $client->secret);
    }
}
