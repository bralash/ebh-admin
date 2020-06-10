<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Utility\Generator;
use Faker\Generator as Faker;
use App\Models\Blood\BloodRequest;

$factory->define(BloodRequest::class, function (Faker $faker) {
    return [
		'requested_by' => rand(1, 5),
		'requester_phone' => '02'.rand(0, 4).Generator::generateCode(7),
		'requester_location_id' => rand(1, 50),
		'blood_type_id' => rand(1, 8),
		'by_donor' => rand(0, 1)
    ];
});
