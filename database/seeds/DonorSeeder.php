<?php

use App\Models\Donation\Donor;
use Illuminate\Database\Seeder;
use App\Models\Donation\Donation;

class DonorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('donors')->delete();

		factory(Donor::class, 10)->create()->each(function($donor) {
			$donor->donations()->save(factory(Donation::class)->make());
		});
    }
}
