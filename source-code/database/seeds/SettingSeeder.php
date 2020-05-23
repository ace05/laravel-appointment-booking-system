<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            [
                'setting_category_id' => 1,
                'name' => 'Site Name',
                'trans_key' => 'name',
                'code' => 'settings.site_name',
                'value' => 'Social Wall',
                'inputs' => null,
                'help' => null,
                'type' => 'text',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 1,
                'name' => 'Logo',
                'trans_key' => 'logo',
                'code' => 'settings.logo',
                'value' => '',
                'help' => 'Your logo must be 200x40 image format',
                'inputs' => null,
                'type' => 'upload',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 1,
                'name' => 'Website Default Language',
                'trans_key' => 'default_language',
                'code' => 'settings.default_language',
                'value' => 'en',
                'help' => null,
                'inputs' => 'table:translations,code|name',
                'type' => 'database',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 1,
                'name' => 'Admin Dashboard Default Language',
                'trans_key' => 'admin_default_language',
                'code' => 'settings.admin_default_language',
                'value' => 'en',
                'help' => null,
                'inputs' => 'table:translations,code|name',
                'type' => 'database',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 1,
                'name' => 'Website Default Currency',
                'trans_key' => 'site_currency',
                'code' => 'settings.site_currency',
                'value' => '$',
                'help' => null,
                'inputs' => 'table:countries,id|full_currency',
                'type' => 'database',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 1,
                'name' => 'Website Default Country',
                'trans_key' => 'default_country',
                'code' => 'settings.site_country',
                'value' => '45',
                'help' => null,
                'inputs' => 'table:countries,id|country',
                'type' => 'database',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 1,
                'name' => 'Website Default City',
                'trans_key' => 'default_city',
                'code' => 'settings.default_city',
                'value' => '1',
                'help' => null,
                'inputs' => 'table:cities,id|name',
                'type' => 'database',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 1,
                'name' => 'Site Commission',
                'trans_key' => 'website_commission',
                'code' => 'settings.website_commission',
                'value' => 10,
                'help' => null,
                'inputs' => null,
                'type' => 'text',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
    		[
                'setting_category_id' => 2,
                'name' => 'Email Verification',
                'trans_key' => 'email_verification',
                'code' => 'settings.email_verification',
                'value' => 'Yes',
                'inputs' => 'Yes,No',
                'help' => null,
                'type' => 'select',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 2,
                'name' => 'Enable Facebook Login',
                'trans_key' => 'enable_facebook_login',
                'code' => 'settings.facebook_login',
                'value' => 'No',
                'inputs' => 'Yes,No',
                'type' => 'select',
                'help' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 2,
                'name' => 'Facebook App ID',
                'trans_key' => 'facebook_app_id',
                'code' => 'settings.facebook_app_id',
                'value' => '',
                'help' => null,
                'inputs' => null,
                'type' => 'text',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 2,
                'name' => 'Facebook App Secret',
                'trans_key' => 'facebook_app_secret',
                'code' => 'settings.facebook_app_secret',
                'value' => '',
                'inputs' => null,
                'help' => null,
                'type' => 'text',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 1,
                'name' => 'Favicon',
                'trans_key' => 'favicon_url',
                'code' => 'settings.favicon_url',
                'value' => '',
                'inputs' => null,
                'help' => 'Favicon should be png image with 16x16.',
                'type' => 'upload',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 3,
                'name' => 'SMTP Host',
                'trans_key' => 'smtp_host_url',
                'code' => 'settings.smtp_host_url',
                'value' => '',
                'inputs' => null,
                'help' => null,
                'type' => 'text',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 3,
                'name' => 'SMTP Port',
                'trans_key' => 'smtp_port_number',
                'code' => 'settings.smtp_port_number',
                'value' => '',
                'inputs' => null,
                'help' => null,
                'type' => 'text',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 3,
                'name' => 'SMTP Username',
                'trans_key' => 'smtp_username',
                'code' => 'settings.smtp_username',
                'value' => '',
                'inputs' => null,
                'help' => null,
                'type' => 'text',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 3,
                'name' => 'SMTP Password',
                'trans_key' => 'smtp_password',
                'code' => 'settings.smtp_password',
                'value' => '',
                'inputs' => null,
                'help' => null,
                'type' => 'text',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 3,
                'name' => 'SMTP Encryption',
                'trans_key' => 'smtp_encryption',
                'code' => 'settings.smtp_encryption',
                'value' => 'tls',
                'inputs' => null,
                'help' => null,
                'type' => 'text',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 3,
                'name' => 'Mail From Address',
                'trans_key' => 'mail_from_address',
                'code' => 'settings.mail_from_address',
                'value' => '',
                'inputs' => null,
                'help' => null,
                'type' => 'text',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 3,
                'name' => 'Mail From Name',
                'trans_key' => 'mail_from_name',
                'code' => 'settings.mail_from_name',
                'value' => '',
                'inputs' => null,
                'help' => null,
                'type' => 'text',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 4,
                'name' => 'Twilio Account Sid',
                'trans_key' => 'twilio_account_sid',
                'code' => 'settings.twilio_account_sid',
                'value' => '',
                'inputs' => null,
                'help' => null,
                'type' => 'text',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 4,
                'name' => 'Twilio Auth Token',
                'trans_key' => 'twilio_auth_token',
                'code' => 'settings.twilio_auth_token',
                'value' => '',
                'inputs' => null,
                'help' => null,
                'type' => 'text',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 4,
                'name' => 'Twilio From Number/Short Code',
                'trans_key' => 'twilio_from',
                'code' => 'settings.twilio_from',
                'value' => '',
                'inputs' => null,
                'help' => null,
                'type' => 'text',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 5,
                'name' => 'Paypal mode',
                'trans_key' => 'paypal_mode',
                'code' => 'settings.paypal_mode',
                'value' => 'Sandbox',
                'inputs' => 'Sandbox,Live',
                'help' => null,
                'type' => 'select',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 5,
                'name' => 'Paypal Client ID',
                'trans_key' => 'paypal_client_id',
                'code' => 'settings.paypal_client_id',
                'value' => '',
                'inputs' => '',
                'help' => null,
                'type' => 'text',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 5,
                'name' => 'Paypal Client Secret',
                'trans_key' => 'paypal_client_secret',
                'code' => 'settings.paypal_client_secret',
                'value' => '',
                'inputs' => '',
                'help' => null,
                'type' => 'text',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 5,
                'name' => 'Paypal Transaction Fee (Percentage)',
                'trans_key' => 'paypal_trans_fee_percentage',
                'code' => 'settings.paypal_trans_fee_percentage',
                'value' => '',
                'inputs' => '',
                'help' => null,
                'type' => 'text',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 5,
                'name' => 'Paypal Transaction Flat Fee',
                'trans_key' => 'paypal_trans_fee_flat',
                'code' => 'settings.paypal_trans_fee_flat',
                'value' => '',
                'inputs' => '',
                'help' => null,
                'type' => 'text',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 6,
                'name' => 'Stripe Pub Key',
                'trans_key' => 'stripe_pub_key',
                'code' => 'settings.stripe_pub_key',
                'value' => '',
                'inputs' => '',
                'help' => null,
                'type' => 'text',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 6,
                'name' => 'Stripe Secret Key',
                'trans_key' => 'stripe_secret_key',
                'code' => 'settings.stripe_secret_key',
                'value' => '',
                'inputs' => '',
                'help' => null,
                'type' => 'text',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 6,
                'name' => 'Stripe Transaction Fee (Percentage)',
                'trans_key' => 'stripe_trans_fee_percentage',
                'code' => 'settings.stripe_trans_fee_percentage',
                'value' => '',
                'inputs' => '',
                'help' => null,
                'type' => 'text',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 6,
                'name' => 'Stripe Transaction Flat Fee',
                'trans_key' => 'stripe_trans_fee_flat',
                'code' => 'settings.stripe_trans_fee_flat',
                'value' => '',
                'inputs' => '',
                'help' => null,
                'type' => 'text',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 7,
                'name' => 'Meta Description',
                'trans_key' => 'meta_description',
                'code' => 'settings.meta_description',
                'value' => '',
                'inputs' => '',
                'help' => null,
                'type' => 'textarea',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'setting_category_id' => 7,
                'name' => 'Meta Keywords',
                'trans_key' => 'meta_keywords',
                'code' => 'settings.meta_keywords',
                'value' => '',
                'inputs' => '',
                'help' => null,
                'type' => 'textarea',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
    	];
        DB::table('settings')->insert($settings);
    }
}