<?php

namespace App\Models;

use App\Models\User;
use App\Models\City;
use Illuminate\Database\Eloquent\Model;

class UserCity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'city_id'
    ];

    public function city()
    {
    	return $this->belongsTo(City::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
