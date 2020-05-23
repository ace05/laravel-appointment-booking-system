<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTypeSeeder::class);
        $this->call(TranslationSeeder::class);
        $this->call(SettingCategorySeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(EmailTemplateSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(CitySeeder::class);
        $this->call(SmsTemplateSeeder::class);
        $this->call(PageSeeder::class);
    }
}
