<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'iso', 'iso3', 'country', 'currency_code', 'currency_name', 'phone_prefix',
        'symbol', 'full_currency', 'is_active'
    ];
}
