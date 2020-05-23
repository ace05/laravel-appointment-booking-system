<?php
namespace App\Core\Translation;

use View;
use Closure;
use App\Models\Translation;
use Illuminate\Config\Repository as Config;
use Illuminate\Foundation\Application;
use Illuminate\View\Factory as ViewFactory;
use App\Core\Translation\TranslationHelpers;

class TranslationMiddleware
{
    protected $translation;
    protected $transHelper;

    public function __construct(Translation $transModel, TranslationHelpers $transHelper)
    {
        $this->translation = $transModel;
        $this->transHelper = $transHelper;
    }

    public function handle($request, Closure $next, $segment = 0)
    {
        if ($request->method() !== 'GET') {
            return $next($request);
        }

        $currentUrl    = $request->getUri();
        $uriLocale     = $this->transHelper->getLocaleFromUrl($currentUrl, $segment);
        $defaultLocale = config('settings.default_language');
        View::share('languages', $this->translation->getLanguages());
        if ($uriLocale) {
            app()->setLocale($uriLocale);
            View::share('currentLocale', $uriLocale);

            return $next($request);
        }

        // If no locale was set in the url, check the browser's locale:
        $browserLocale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
        if ($this->translation->isValidLocale($browserLocale) && ($browserLocale == $defaultLocale)) {
            return redirect()->to($this->transHelper->localize($currentUrl, $browserLocale, $segment));
        }

        // If not, redirect to the default locale:
        // Keep flash data.
        if ($request->hasSession()) {
            $request->session()->reflash();
        }

        return redirect()->to($this->transHelper->localize($currentUrl, $defaultLocale, $segment));
    }
}