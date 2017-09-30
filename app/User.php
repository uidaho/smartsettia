<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone'
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
     * Update the updated_at and created_at timestamps?
     *
     * @var array
     */
    public $timestamps = true;

    /**
     * Route notifications for the Nexmo channel.
     *
     * @return string
     */
    public function routeNotificationForNexmo()
    {
        return $this->phone;
    }
    
    /**
     * Is user Admin or better?
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->role > 2;
    }
    
    /**
     * Is user Manager or better?
     *
     * @return boolean
     */
    public function isManager()
    {
        return $this->role > 1;
    }

    /**
     * Is user User or better?
     *
     * @return boolean
     */
    public function isUser()
    {
        return $this->role > 0;
    }
    
    /**
     * Is user a guest?
     *
     * @return boolean
     */
    public function isGuest()
    {
        return $this->role == 0;
    }
    
    
    /**
     * Returns a list of managers.
     *
     * @return Users
     */
    public function managers()
    {
        return $this->where('role', '>', 1)->get();
    }
}
