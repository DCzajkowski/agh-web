<?php

use Faker\Generator as Faker;

$factory->define(\App\Book::class, function (Faker $faker) {
    return [
        'title' => implode(' ', $faker->words(4)),
        'author' => $faker->firstName . ' ' . $faker->lastName,
        'publisher_id' => random_int(1, 172),
        'barcode' => $faker->ean13,
        'release_date' => $faker->date('Y-m-d'),
    ];
});
