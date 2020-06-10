<?php

use Illuminate\Database\Seeder;
use App\Models\Donation\Donation;
use App\Models\Blood\BloodRequest;

class BloodRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		factory(BloodRequest::class, 50)->create();
        //
    }
}
