<?php

use Illuminate\Database\Seeder;

class GalleriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        // Create 5 galleries
        for ($i = 0; $i < 5; $i++) {
            DB::table('galleries')->insert([
                'user_id' => 1,
                'title' => $faker->unique()->sentence(),
            ]);
        }

    }
}
