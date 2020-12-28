<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('customers')->insert([
            'number' => 'rohith',
            'otp' => Str::random(5),
            'fcm_token' => Hash::make('rohith'),
            'status' => 1,
        ]);
    }
}
