<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Utility\Generator;
use Faker\Generator as Faker;
use App\Models\Donation\Donation;

$factory->define(Donation::class, function (Faker $faker) {
    return [
		'donor_id' => rand(1, 10),
		'donation_type' => rand(1, 2),
		'event_id' => rand(1,5),
		'volume' => 100,
		'stage' => rand(1, 3),
		'donation_uid' => Generator::generateCode(5)
    ];
});
