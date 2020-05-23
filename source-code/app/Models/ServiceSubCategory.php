<?php

namespace App\Models;

use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceSubCategory extends Model
{
	use SoftDeletes, Sluggable;

    protected $fillable = [
    	'name', 'slug', 'cover', 'is_active', 'service_category_id'
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

    public function category()
    {
    	return $this->belongsTo(ServiceCategory::class, 'service_category_id')->withTrashed();
    }
}
