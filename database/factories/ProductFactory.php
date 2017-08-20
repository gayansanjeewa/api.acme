<?php

use App\Product;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $fake) {
    $user = factory(User::class)->create();
    return [
        'name' => $fake->word,
        'price' => $fake->randomFloat(2),
        'status' => 1,
        'user_id' => $user->id,
        'published_at' => Carbon::now(),
    ];
});
