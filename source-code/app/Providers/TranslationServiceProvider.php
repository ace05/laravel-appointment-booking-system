<?php

namespace App\Providers;

use App\Models\Translation;
use Illuminate\Support\ServiceProvider;
use App\Core\Translation\TranslationHelpers;

class TranslationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadJsonTranslationsFrom(storage_path('lang'));
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('translation.helpers',  function ($app){
            return new TranslationHelpers($app->request, app(Translation::class));
        });
    }
}
