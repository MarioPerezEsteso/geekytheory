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
    ];
});

$factory->define(App\Subscriber::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->email,
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