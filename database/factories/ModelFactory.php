<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'username' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'can_login' => true,
    ];
});

$factory->define(App\UserMeta::class, function () {
    return [
        'biography' => 'Developer and engineer.',
        'job' => 'Laravel developer',
        'twitter' => 'https://twitter.com/geekytheory',
        'instagram' => 'https://instagram.com/geekytheory',
        'facebook' => 'https://facebook.com/geekytheory',
        'github' => 'https://github.com/geekytheory',
        'youtube' => 'https://youtube.com/',
        'googleplus' => 'https://gplus.com',
        'stackoverflow' => 'https://so.com',
        'bitbucket' => 'https://bitbucket.com',
        'linkedin' => 'https://linkedin.com',
        'tumblr' => 'https://tumblr.com',
        'twitch' => 'https://twitch.com',
        'vimeo' => 'https://vimeo.com',
    ];
});

$factory->define(App\Subscriber::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->email,
        'token' => $faker->sha256,
    ];
});

$factory->define(App\Course::class, function (Faker\Generator $faker) {
    return [
        'slug' => $faker->slug,
        'title' => $faker->text,
        'description' => $faker->text,
        'image' => $faker->url,
        'difficulty' => 'easy',
        'duration' => 100,
        'students' => 50,
        'free' => false,
        'status' => 'published',
    ];
});

$factory->define(App\Chapter::class, function () {
    return [];
});

$factory->define(App\Lesson::class, function () {
    return [];
});

$factory->define(\Laravel\Cashier\Subscription::class, function () {
    return [];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    return [
        'post_id' => 1,
        'user_id' => 1,
        'parent' => null,
        'author_name' => $faker->name,
        'author_email' => $faker->email,
        'author_url' => null,
        'body' => $faker->text,
        'approved' => true,
        'spam' => false,
        'ip' => $faker->ipv4,
    ];
});