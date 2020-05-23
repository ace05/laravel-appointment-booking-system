<?php

use Illuminate\Database\Seeder;

class SmsTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $templates = [
            [
                'name' => 'OTP verification',
                'slug' => 'otp-verification',
                'tags' => '##SITENAME##, ##OTP##',
                'template' => 'Your ##SITENAME## verification code is: ##OTP##'
             ]
         ];

        DB::table('sms_templates')->insert($templates);
    }
}
