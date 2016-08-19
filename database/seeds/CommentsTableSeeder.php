<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        DB::table('comments')->insert([
            'post_id' => 1,
            'user_id' => 1,
            'author_name' => 'John Doe',
            'author_email' => 'johndoe@domain.com',
            'author_url' => 'http://doe.com',
            'content' => $faker->text(),
            'approved' => 1,
            'spam' => 0,
            'ip' => '0.0.0.0',
        ]);

        DB::table('comments')->insert([
            'post_id' => 1,
            'parent' => 1,
            'author_name' => 'Mario P.',
            'author_email' => 'mario@domain.com',
            'author_url' => 'http://mario.com',
            'content' => $faker->text(),
            'approved' => 1,
            'spam' => 0,
            'ip' => '0.0.0.0',
        ]);

        DB::table('comments')->insert([
            'post_id' => 1,
            'user_id' => 1,
            'parent' => 2,
            'author_name' => 'John Doe',
            'author_email' => 'johndoe@domain.com',
            'author_url' => 'http://doe.com',
            'content' => $faker->text(),
            'approved' => 1,
            'spam' => 0,
            'ip' => '0.0.0.0',
        ]);

        DB::table('comments')->insert([
            'post_id' => 1,
            'author_name' => 'Bob',
            'author_email' => 'bob@domain.com',
            'author_url' => 'http://bobbob.com',
            'content' => $faker->text(),
            'approved' => 1,
            'spam' => 0,
            'ip' => '0.0.0.0',
        ]);
    }
}
