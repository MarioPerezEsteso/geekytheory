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
        for ($i = 0; $i < 15; $i++) {
            DB::table('posts')->insert([
                'user_id' => 1,
                'title' => $faker->unique()->sentence(),
                'body' => $faker->text(),
                'description' => $faker->text($maxNbChars = 150),
                'slug' => $faker->unique()->word,
                'status' => 'published',
                'image' => 'some_image',
                'type' => 'article',
                'published_at' => \Carbon\Carbon::now(),
            ]);
        }

        // Create 2 articles with known body and title (for testing findArticlesBySearch)
        DB::table('posts')->insert([
            'user_id' => 1,
            'title' => 'Tutorial Arduino',
            'body' => 'Arduino tutorial in this blog',
            'description' => $faker->text($maxNbChars = 150),
            'slug' => 'tutorial-arduino',
            'status' => 'published',
            'image' => 'some_image',
            'type' => 'article',
            'published_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('posts')->insert([
            'user_id' => 1,
            'title' => 'Tutorial Android',
            'body' => 'Android tutorial in this blog',
            'description' => $faker->text($maxNbChars = 150),
            'slug' => 'tutorial-android',
            'status' => 'published',
            'image' => 'some_image',
            'type' => 'article',
            'published_at' => \Carbon\Carbon::now(),
        ]);

        for ($i = 0; $i < 3; $i++) {
            DB::table('posts')->insert([
                'user_id' => 1,
                'title' => $faker->unique()->sentence(),
                'body' => $faker->text(),
                'description' => $faker->text($maxNbChars = 150),
                'slug' => $faker->unique()->word,
                'status' => 'draft',
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
