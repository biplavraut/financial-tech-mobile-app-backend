<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Custom\Contracts\ImageableContract;
use App\Custom\Traits\Imageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements ImageableContract
{
    use HasApiTokens, HasFactory, Notifiable, Imageable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['password'];

    public $columnsWithTypes = [
        'salutation'        => 'string',
        'first_name'        => 'string',
        'middle_name'        => 'string',
        'last_name'        => 'string',
        'gender' => 'string',
        'country_code'       => 'string',
        'phone'       => 'string',
        'phone_verified' => 'boolean',
        'phone_verified_at' => 'string',
        'email'       => 'string',
        'email_verified_at' => 'string',
        'password'    => 'password',        
        'image' => 'image',
        'dob' => 'string',
        'refer_code' => 'string',
        'refer_by' => 'string',
        'blocked' => 'boolean',
        'registered_from' => 'string',
        'last_login_at' => 'string',
        
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function verifyPhone()
    {
        $this->phone_verified_at    = now();
        $this->phone_verified = 1;
        $this->save();
    }

    public function isPhoneVerified(){
        return $this->phone_verified == 1 ? true : false;
    }


    public function verifyEmail()
    {
        $this->email_verified_at    = now();
        $this->save();
    }

    public function getFullNameAttribute(){
        return $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
    }
    /**
     * Get all of the devices for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userLogs(): HasMany
    {
        return $this->hasMany(UserLog::class, 'user_id');
    }

    public function myKyc()
    {
        return $this->hasMany(Kyc::class, 'user_id')->where('self', true);
    }

    /**
     * Get all of the devices for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kyc(): HasMany
    {
        return $this->hasMany(Kyc::class, 'user_id');
    }
    
}
