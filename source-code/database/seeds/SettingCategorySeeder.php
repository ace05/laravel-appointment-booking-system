<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SettingCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$categories = [
            [
                'id' => 1,
                'name' => 'General',
                'slug' => 'general',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
    		[
                'id' => 2,
    		    'name' => 'Register and Login',
    		    'slug' => 'register-and-login',
    		    'created_at' => Carbon::now(),
    		    'updated_at' => Carbon::now()
            ],
            [
                'id' => 3,
    		    'name' => 'Mail SMTP Settings',
    		    'slug' => 'mail-smtp-settings',
    		    'created_at' => Carbon::now(),
    		    'updated_at' => Carbon::now()
            ],
            [
                'id' => 4,
                'name' => 'Twilio SMS Settings',
                'slug' => 'twilio-sms-settings',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 5,
                'name' => 'Paypal Settings',
                'slug' => 'paypal-settings',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 6,
                'name' => 'Stripe Settings',
                'slug' => 'stripe-settings',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 7,
                'name' => 'SEO Settings',
                'slug' => 'seo-settings',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
    	];
        DB::table('setting_categories')->insert($categories);
    }
}
