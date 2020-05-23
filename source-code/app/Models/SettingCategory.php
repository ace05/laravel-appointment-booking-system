<?php

namespace App\Models;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Model;

class SettingCategory extends Model
{
    protected $fillable = [];

    public function settings()
    {
        return $this->hasMany(Setting::class);
    }
}
