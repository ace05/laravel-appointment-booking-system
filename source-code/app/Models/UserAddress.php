<?php

namespace App\Models;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'flat_no', 'address_line1', 'address_line2', 'pincode',
        'city_id', 'country_id'
    ];

    public function city()
    {
    	return $this->belongsTo(City::class);
    }

    public function country()
    {
    	return $this->belongsTo(Country::class);
    }
}
