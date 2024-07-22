<?php

namespace App\Models;

use App\Custom\Contracts\ImageableContract;
use App\Custom\Traits\CreatedUpdatedBy;
use App\Custom\Traits\Imageable;
use App\Custom\Traits\Routeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable implements ImageableContract
{
    use HasFactory;
    use HasApiTokens;
    use Notifiable;
    use Imageable, Routeable;
    use SoftDeletes;
    use CreatedUpdatedBy;

    protected $guard = 'admin';

    public $columnsWithTypes = [
        'name'        => 'string',
        'user_name'        => 'string',
        'phone'       => 'string',
        'email'       => 'string',
        'password'    => 'password',
        'image'       => 'image',
        'role'    => 'string',
        'address'       => 'string',
        'blocked'       => 'boolean',
        'verified'    => 'string',
        'last_login_at' => 'string'
        
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];
}
