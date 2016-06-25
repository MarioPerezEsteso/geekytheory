<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        // Create 10 articles
        for ($i = 0; $i < 10; $i++) {
            DB::table('posts')->insert([
                'user_id' => 1,
                'title' => $faker->unique()->sentence(),
                'body' => $faker->text(),
                'description' => $faker->text($maxNbChars = 150),
                'slug' => $faker->unique()->word,
                'status' => 'published',
                'image' => 'some_image',
                'type' => 'article',
            ]);
        }
        // Create 10 pages
        for ($i = 0; $i < 10; $i++) {
            DB::table('posts')->insert([
                'user_id' => 1,
                'title' => $faker->unique()->sentence(),
                'body' => $faker->text(),
                'description' => $faker->text($maxNbChars = 150),
                'slug' => $faker->unique()->word,
                'status' => 'published',
                'image' => 'some_image',
                'type' => 'page',
            ]);
        }
    }
}
