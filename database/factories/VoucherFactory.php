<?php

use App\Helpers\EnumHelper;
use App\Models\Voucher;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Store Product and Store Order Model Factories
|--------------------------------------------------------------------------
*/

$factory->define(Voucher::class, function (Faker $faker) {
    $date = $faker->dateTimeBetween('-2 months', 'now');
    $expiration = $faker->dateTimeBetween('2 months', '1 year');

    return [
        'reference' => $faker->isbn10(),
        'voucher' => $faker->isbn10(),
        'value' => $faker->randomElement([5, 10, 20, 50]),
        'client_name' => $faker->firstName . ' ' . $faker->lastName,
        'client_email' => $faker->unique()->safeEmail,
        'expiration' => $expiration,
        'status' => $faker->randomElement(EnumHelper::get('store.voucher')),
        'created_at' => $date,
        'updated_at' => $date,
    ];
});
