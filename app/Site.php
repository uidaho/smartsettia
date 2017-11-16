<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Facades\Auth;

class Site extends Model
{
    use LogsActivity;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
    
    /**
     * The attributes to ignore in the Activity Log
     *
     * @var array
     */
    protected static $ignoreChangedAttributes = ['updated_at'];
    
    /**
     * The attributes to log in the Activity Log
     *
     * @var array
     */
    protected static $logAttributes = [
        'name'
    ];
    
    /**
     * Only log those that have actually changed after the update.
     *
     * @var array
     */
    protected static $logOnlyDirty = true;
    
    /**
     * Update the updated_at and created_at timestamps?
     *
     * @var array
     */
    public $timestamps = true;
    
    /**
     * Get the locations for the site.
     */
    public function locations()
    {
        return $this->hasMany('App\Location');
    }
    
    /**
     * Get the devices for the site.
     */
    public function devices()
    {
        return $this->hasManyThrough('App\Device', 'App\Location');
    }
    
    /**
     * Accessor: Get the site's last update time in seconds/minutes/hours since update or converted to user
     * friendly readable format.
     * If the time is less then a day old then display time since it last updated
     * If the time is greater then a day old then display the time in the format of Month day, year 12hour:mins am/pm
     * and using the user's preferred timezone
     *
     *
     * @return string
     */
    public function getUpdatedAtHumanAttribute()
    {
        if ($this->updated_at->diffInDays() > 0)
            return $this->updated_at->setTimezone(Auth::user()->timezone)->format('M d, Y h:i a');
        else
            return $this->updated_at->diffForHumans();
    }
    
    /**
     * Accessor: Get the site's creation time in seconds/minutes/hours since update or converted to user
     * friendly readable format.
     * If the time is less then a day old then display time since creation
     * If the time is greater then a day old then display the time in the format of Month day, year 12hour:mins am/pm
     * and using the user's preferred timezone
     *
     *
     * @return string
     */
    public function getCreatedAtHumanAttribute()
    {
        if ($this->created_at->diffInDays() > 0)
            return $this->created_at->setTimezone(Auth::user()->timezone)->format('M d, Y h:i a');
        else
            return $this->created_at->diffForHumans();
    }
}
