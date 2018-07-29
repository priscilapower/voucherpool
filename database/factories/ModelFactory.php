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

/*$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
    ];
});*/

$factory->define(App\Recipients::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
    ];
});

$factory->define(App\SpecialOffers::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->sentence,
        'percentage_discount' => $faker->randomNumber(2),
    ];
});

$factory->define(App\VoucherCodes::class, function (Faker\Generator $faker) {
    $recipientsIDs = \Illuminate\Support\Facades\DB::table('recipients')->pluck('id');
    $specialOfferIDs = \Illuminate\Support\Facades\DB::table('special_offers')->pluck('id');

    return [
        'code' => str_random(8),
        'used' => false,
        'expiration_date' => $faker->creditCardExpirationDate,
        'recipient_id' => $faker->randomElement($recipientsIDs),
        'special_offer_id' => $faker->randomElement($specialOfferIDs),
    ];
});
