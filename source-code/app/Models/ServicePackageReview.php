<?php

namespace App\Models;

use App\Models\User;
use App\Models\ServicePackage;
use Illuminate\Database\Eloquent\Model;

class ServicePackageReview extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'service_package_id', 'rating', 'comments'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function package()
    {
    	return $this->belongsTo(ServicePackage::class);
    }
}
