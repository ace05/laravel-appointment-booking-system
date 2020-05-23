<?php 
namespace App\Core\Facades;

use Illuminate\Support\Facades\Facade;

class TranslationHelpers extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'translation.helpers';
    }
}