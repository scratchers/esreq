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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'institution_id' => function () {
            return factory(App\Institution::class)->create()->id;
        }
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Institution::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->unique()->company,
        'url' => "https://example.com/{$faker->unique()->slug}",
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Esrequest::class, function (Faker\Generator $faker) {
    return [
        'faculty_accounts' => 1,
        'student_accounts' => $faker->numberBetween(20, 100),
        'user_comment' => $faker->text,
    ];
});
