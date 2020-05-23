<?php

namespace App\Models;

use Cache;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $fillable = ['name', 'code', 'is_active'];

    public function getLanguages()
    {
    	$languages = Cache::get('languages');
        if(empty($languages) === true){
            $languages = $this->where('is_active', '=', true)
            					->pluck('name', 'code')
            					->toArray();
            Cache::forever('languages', $languages);
        }
        
        return $languages;
    }

    public function isValidLocale($code)
    {
    	return $this->where('code', '=', $code)->count() > 0;
    }
}
