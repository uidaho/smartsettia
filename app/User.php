<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
//use Spatie\Activitylog\Traits\CausesActivity;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use LogsActivity;
    //use CausesActivity;

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
     * The attributes to ignore in the Activity Log
     *
     * @var array
     */
    protected static $ignoreChangedAttributes = [
        'updated_at', 'remember_token'
    ];
    
    /**
     * The attributes to log in the Activity Log
     *
     * @var array
     */
    protected static $logAttributes = [
        'name', 'email', 'password', 'role', 'phone'
    ];
    
    /**
     * Only log those that have actually changed after the update.
     *
     * @var array
     */
    protected static $logOnlyDirty = true;

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
    
    /**
     * Returns the users role as a string.
     *
     * @return Users
     */
    public function roleString()
    {
        $role_en = array(0 => "Registered", 1 => "User", 2 => "Manager", 3 => "Admin");
        return $role_en[ $this->role ] . ' (' . $this->role . ')';
    }
}
