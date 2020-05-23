<?php

namespace App\Models;

use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
	use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id', 'name', 'is_active'
    ];

    protected $dates = ['deleted_at'];

    public function country()
    {
    	return $this->belongsTo(Country::class);
    }

    public function getCities($countryId)
    {
    	return $this->where('country_id', '=', $countryId)
    				->where('is_active', '=', true)
    				->pluck('name', 'id')
    				->toArray();
    }
}
