<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('discount')->insert([
            'value' => 10,
            'type' => 0, // -%
            'code' => 'DA10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('discount')->insert([
            'value' => 5,
            'type' => 1, // -5
            'code' => 'BA05',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('discount')->insert([
            'value' => 20,
            'type' => 1, // -%
            'user' => 1, // for registered user
            'code' => 'TADA20',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
