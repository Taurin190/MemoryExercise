<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\StudyHistory;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(StudyHistory::class, function (Faker $faker) {
    return [
        'study_id' => $faker->numberBetween(1, 10000),
        'user_id' => $faker->numberBetween(1, 10000),
        'workbook_id' => $faker->uuid,
        'exercise_id' => $faker->uuid,
        'score' => $faker->numberBetween(1, 3)
    ];
});
