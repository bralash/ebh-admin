<?php

use App\Models\User\User;
use Illuminate\Database\Seeder;
use App\Models\User\UserAccessKey;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        DB::table('users')->insert([
            [
                'name' => 'John Doe',
                'phone' => '0200000000',
                'password' => bcrypt('password'),
                'account_type' => 1,
                'account_id' => 1,
            ],
            [
                'name' => 'Jane Doe',
                'phone' => '0244444444',
                'password' => bcrypt('password'),
                'account_type' => 1,
                'account_id' => 1,
            ]
        ]);

        // Create user access keys
        DB::table('user_access_keys')->delete();
        DB::table('user_access_keys')->insert([
            [
                'user_id' => 1,
                'api_key' => UserAccessKey::new(),
            ],
            [
                'user_id' => 2,
                'api_key' => UserAccessKey::new(),
            ],
		]);
    }
}
