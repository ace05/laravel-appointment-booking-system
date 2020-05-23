<?php

use Illuminate\Database\Seeder;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [
        	[
        		'id' => 1,
        		'name' => 'English',
        		'code' => 'en',
        		'is_active' => true
        	]
        ];

        DB::table('translations')->insert($languages);
    }
}
