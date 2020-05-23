<?php

use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
        	[
        		'id' => 1,
        		'country_id' => 45,
        		'name' => 'Chennai',
        		'is_active' => true
        	]
        ];

        DB::table('cities')->insert($cities);
    }
}
