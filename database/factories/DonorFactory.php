<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Utility\Generator;
use Faker\Generator as Faker;
use App\Models\Donation\Donor;

$factory->define(Donor::class, function (Faker $faker) {
    return [
		'firstname' => $faker->firstName,
		'lastname' => $faker->lastName,
		'phone' => '02'.rand(0, 4).Generator::generateCode(7),
		'community_id' => rand(1, 50),
		'date_of_birth' => $faker->dateTimeBetween('-40 years', '-18 years'),
		'blood_type_id' => rand(1, 8),
		'badge_id' => 1,
    ];
});
