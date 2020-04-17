<?php

use Illuminate\Database\Seeder;

class BloodTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('blood_types')->delete();

        DB::table('blood_types')->insert([
            [
                'name' => 'A+',
                'code' => 'APS'
            ],
            [
                'name' => 'A-',
                'code' => 'AMS'
            ],
            [
                'name' => 'B+',
                'code' => 'BPS'
            ],
            [
                'name' => 'B-',
                'code' => 'BMS'
            ],
            [
                'name' => 'O+',
                'code' => 'OPS'
            ],
            [
                'name' => 'O-',
                'code' => 'OMS'
            ],
            [
                'name' => 'AB+',
                'code' => 'ABP'
            ],
            [
                'name' => 'AB-',
                'code' => 'ABM'
            ],
        ]);
        //
    }
}
