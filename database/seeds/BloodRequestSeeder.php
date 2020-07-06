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
		DB::table('blood_requests')->delete();
		factory(BloodRequest::class, 50)->create();
        //
    }
}
