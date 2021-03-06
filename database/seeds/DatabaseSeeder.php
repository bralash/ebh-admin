<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(CommunityTableSeeder::class);
		$this->call(BadgeTableSeeder::class);
        $this->call(BloodTypeTableSeeder::class);
		$this->call(BloodRequestSeeder::class);
		$this->call(DonorSeeder::class);
    }
}
