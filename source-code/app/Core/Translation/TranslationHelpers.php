<?php 
namespace App\Core\Translation;

use App\Models\Translation;
use Illuminate\Http\Request;

class TranslationHelpers
{
    public function __construct(Request $request, Translation $transModel)
    {
        $this->request = $request;
        $this->transModel = $transModel;
    }

    public function localeFromRequest($segment = 0)
    {
        $url = $this->request->getUri();
        return $this->getLocaleFromUrl($url, $segment);
    }

    public function localize($url, $locale, $segment = 0)
    {
        $cleanUrl  = $this->cleanUrl($url, $segment);
        $parsedUrl = $this->parseUrl($cleanUrl, $segment);

        if (count($parsedUrl['segments']) >= $segment) {
            array_splice($parsedUrl['segments'], $segment, 0, $locale);
        }
        return $this->pathFromParsedUrl($parsedUrl);
    }

    public function getLocaleFromUrl($url, $segment = 0)
    {
        return $this->parseUrl($url, $segment)['locale'];
    }

    public function cleanUrl($url, $segment = 0)
    {
        $parsedUrl = $this->parseUrl($url, $segment);
        // Remove locale from segments:
        if ($parsedUrl['locale']) {
            unset($parsedUrl['segments'][$segment]);
            $parsedUrl['locale'] = false;
        }
        return $this->pathFromParsedUrl($parsedUrl);
    }

    protected function parseUrl($url, $segment = 0)
    {
        $parsedUrl             = parse_url($url);
        $parsedUrl['segments'] = array_values(array_filter(explode('/', $parsedUrl['path']), 'strlen'));
        $localeCandidate       = array_get($parsedUrl['segments'], $segment, false);
        $parsedUrl['locale']   = $localeCandidate;
        $locales = array_keys($this->transModel->getLanguages());
        $parsedUrl['locale']   = in_array($localeCandidate, $locales) ? $localeCandidate : null;
        $parsedUrl['query']    = array_get($parsedUrl, 'query', false);
        $parsedUrl['fragment'] = array_get($parsedUrl, 'fragment', false);
        unset($parsedUrl['path']);
        return $parsedUrl;
    }

    protected function pathFromParsedUrl($parsedUrl)
    {
        $path = '/' . implode('/', $parsedUrl['segments']);
        if ($parsedUrl['query']) {
            $path .= "?{$parsedUrl['query']}";
        }
        if ($parsedUrl['fragment']) {
            $path .= "#{$parsedUrl['fragment']}";
        }
        return $path;
    }

    protected function removeFrontSlash($path)
    {
        return strlen($path) > 0 && substr($path, 0, 1) === '/' ? substr($path, 1) : $path;
    }

    protected function removeTrailingSlash($path)
    {
        return strlen($path) > 0 && substr($path, -1) === '/' ? substr($path, 0, -1) : $path;
    }
}