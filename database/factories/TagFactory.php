<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Tag::class, function (Faker $faker) {
    $name = $faker->word;
    $date = $faker->dateTimeThisYear();
    return [
        'name' => $name,
        'description' => $name . $faker->sentence(),
        'view_count' => $faker->numberBetween(100,1000),
        'created_at' => $date,
        'updated_at' => $date,
    ];
});
