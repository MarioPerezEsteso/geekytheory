<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'          => 'user',
            'email'         => 'alias@domain.com',
            'password'      => bcrypt('password'),
            'created_at'    => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at'    => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
    }
}
