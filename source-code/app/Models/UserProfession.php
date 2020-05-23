<?php

namespace App\Models;

use App\Models\User;
use App\Models\ServiceSubCategory;
use Illuminate\Database\Eloquent\Model;

class UserProfession extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'service_sub_category_id'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function profession()
    {
    	return $this->belongsTo(ServiceSubCategory::class);
    }
}
