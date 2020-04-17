<?php

use Illuminate\Database\Seeder;

class BadgeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('badges')->delete();

        DB::table('badges')->insert([
            [
                'name' => 'Regular',
                'points' => '0',
            ]
        ]);

        //
    }
}
