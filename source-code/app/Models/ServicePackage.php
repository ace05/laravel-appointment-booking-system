<?php

namespace App\Models;

use App\Models\User;
use App\Models\City;
use App\Models\Attachment;
use App\Models\ServiceSubCategory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class ServicePackage extends Model
{
	use Sluggable;

    protected $fillable = [
        'user_id', 'name', 'details', 'inclusion', 'exclusion', 'conditions',
        'is_active', 'is_approved', 'is_allow_appointment', 'price', 'discount',
        'slug', 'is_address_required', 'city_id', 'service_sub_category_id', 'rating'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function profession()
    {
        return $this->belongsTo(ServiceSubCategory::class, 'service_sub_category_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function cover()
    {
        return $this->hasOne(Attachment::class, 'foreign_id', 'id')
        			->where('type', '=', 'Package');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
