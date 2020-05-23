<?php

namespace App\Models;

use App\Models\User;
use App\Models\OrderAddress;
use App\Models\ServicePackage;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'order_address_id', 'price', 'discount', 'service_package_id', 
        'appointment_date', 'is_paid', 'is_cancelled', 'is_accepted', 'is_completed', 
        'reference_id'
    ];

    public function package()
    {
    	return $this->belongsTo(ServicePackage::class, 'service_package_id');
    }

    public function address()
    {
    	return $this->belongsTo(OrderAddress::class, 'order_address_id');
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
