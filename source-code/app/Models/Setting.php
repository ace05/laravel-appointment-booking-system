<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [];


    public function getSettings()
    {
    	return $this->pluck('value', 'code')
    				->toArray();
    }

}
