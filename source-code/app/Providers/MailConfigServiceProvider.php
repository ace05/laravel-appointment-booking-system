<?php

namespace App\Providers;

use DB;
use Schema;
use Config;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if(Schema::hasTable('settings')){            
            $settings = DB::table('settings')->where('setting_category_id', '=', 3)
                                    ->pluck('value', 'code')
                                    ->toArray();
            if(empty($settings) === false){            
                $config = [
                    'driver'     => 'smtp',
                    'host'       => $settings['settings.smtp_host_url'],
                    'port'       => $settings['settings.smtp_port_number'],
                    'from'       => array('address' => $settings['settings.mail_from_address'], 'name' => $settings['settings.mail_from_name']),
                    'encryption' => $settings['settings.smtp_encryption'],
                    'username'   => $settings['settings.smtp_username'],
                    'password'   => $settings['settings.smtp_password'],
                    'sendmail'   => '/usr/sbin/sendmail -bs',
                    'pretend'    => false,
                ];

                Config::set('mail', $config);
            }
        }
    }
}