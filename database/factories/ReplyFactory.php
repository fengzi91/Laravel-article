<?php

use Faker\Generator as Faker;
use App\Handlers\TextHandler;
$factory->define(App\Models\Reply::class, function (Faker $faker) {
    
    $time = $faker->dateTimeThisMonth();
    $cn = new TextHandler;
    return [
        'content' => $cn->juzi(),
        'created_at' => $time,
        'updated_at' => $time,
    ];
});
