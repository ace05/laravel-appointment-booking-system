<?php

namespace App\Models;

use App\Models\City;
use App\Models\UserType;
use App\Models\Attachment;
use App\Models\UserProfile;
use App\Models\UserAccount;
use App\Models\UserAddress;
use App\Models\ServiceProvider;
use App\Models\ServiceSubCategory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'email_verification_token', 
        'user_type_id', 'ip', 'user_agent', 'is_email_verified', 'is_active', 
        'is_blocked', 'available_balance','total_earnings', 'mobile',
        'email_verification_date', 'otp_code', 'otp_verification_token','is_mobile_verified', 'alt_mobile_number', 'rating', 'site_commissions'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['deleted_at'];


    public function userType()
    {
        return $this->belongsTo(UserType::class);
    }

    public function getName()
    {
        $name = $this->first_name;
        if(empty($this->last_name) === false){
            $name = $name.' '.$this->last_name;
        }
        return $name;
    }

    public function getAccountByName($name, $id)
    {
        return $this->hasOne(UserAccount::class)->where('provider', '=', strtolower($name))
                            ->where('login', '=', $id);
    }

    public function professions()
    {
        return $this->belongsToMany(ServiceSubCategory::class, 'user_professions');
    }

    public function cities()
    {
        return $this->belongsToMany(City::class, 'user_cities');
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function professionalAddress()
    {
        return $this->hasOne(UserAddress::class);
    }

    public function avatar()
    {
        return $this->hasOne(Attachment::class, 'foreign_id')
                    ->where('type', '=', 'User');
    }

    public function serviceProvider()
    {
        return $this->hasOne(ServiceProvider::class);
    }


}
