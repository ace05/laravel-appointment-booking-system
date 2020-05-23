<?php

use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
        	[
        		'title' => 'Terms and Conditions',
        		'slug' => 'terms-and-conditions',
        		'details' => '<h4>Terms and Conditions</h4>'
        	]
        ];

        Db::table('pages')->insert($pages);
    }
}
