<?php

use Illuminate\Database\Seeder;
use App\Models\Donation\Donation;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		factory(Donation::class, 50)->create()->each(function ($user) {
			$user->posts()->save(factory(App\Post::class)->make());
		});
        //
    }
}
