<?php

namespace App\Models;

use App\Models\ServiceSubCategory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceCategory extends Model
{
	use SoftDeletes, Sluggable;

    protected $fillable = [
    	'name', 'slug', 'cover', 'is_active'
    ];

    protected $dates = ['deleted_at'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function subCategories()
    {
        return $this->hasMany(ServiceSubCategory::class)->limit(4);
    }
}
