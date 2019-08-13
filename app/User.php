<?php

namespace App;

use Backpack\Base\app\Notifications\ResetPasswordNotification as ResetPasswordNotification;
use Backpack\CRUD\CrudTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use CrudTrait;
    use HasRoles;
    use Notifiable;

    const ROLE_ADMIN = 1;
    const ROLE_VOLUNTEER = 2;
    const ROLE_STORE = 4;
    const ROLE_TRANSLATOR = 8;
    const ROLE_ALL = 15;

    const PERMISSION_PROCESSES = 1;
    const PERMISSION_APPOINTMENTS = 2;
    const PERMISSION_TREATMENTS = 4;
    const PERMISSION_ADOPTIONS = 8;
    const PERMISSION_ACCOUNTANCY = 16;
    const PERMISSION_WEBSITE = 32;
    const PERMISSION_STORE = 64;
    const PERMISSION_FRIEND_CARD = 128;
    const PERMISSION_VETS = 256;
    const PERMISSION_PROTOCOLS = 512;
    const PERMISSION_COUNCIL = 1024;
    const PERMISSION_STORE_ORDERS = 2048;
    const PERMISSION_STORE_SHIPPMENTS = 4096;
    const PERMISSION_STORE_STOCK = 8192;
    const PERMISSION_STORE_TRANSACTION = 16384;
    const PERMISSION_ALL = 32767;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
        'phone', 'friend_card_modality', 'status', 'notes',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function headquarters()
    {
        return $this->belongsToMany('App\Models\Headquarter', 'users_headquarters', 'user_id', 'headquarter_id');
    }

    public function friend_card_modality()
    {
        return $this->belongsTo('App\Models\FriendCardModality', 'friend_card_modality_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
