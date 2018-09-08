<?php

use Faker\Generator as Faker;
use App\Handlers\TextHandler;

$factory->define(App\Models\Tag::class, function (Faker $faker) {
    $cn = new TextHandler;
    $name = $cn->name([1,3]);
    $date = $faker->dateTimeThisYear();
    return [
        'name' => $name,
        'description' => $name . $cn->text([10,30]),
        'view_count' => $faker->numberBetween(100,1000),
        'created_at' => $date,
        'updated_at' => $date,
    ];
});
