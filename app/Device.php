<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;

class Device extends Model
{
    use SoftDeletes;
    use LogsActivity;
    //use CausesActivity;
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'last_network_update_at'
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['token'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'location_id', 'uuid', 'version', 'hostname', 'ip', 'mac_address', 
        'time', 'cover_command', 'cover_status', 'error_msg', 'limitsw_open', 'limitsw_closed',
        'light_in', 'light_out', 'update_rate', 'image_rate', 'sensor_rate', 
        'open_time', 'close_time', 'last_network_update_at',
    ];
    
    /**
     * The attributes to ignore in the Activity Log
     *
     * @var array
     */
    protected static $ignoreChangedAttributes = ['updated_at', 'last_network_update_at'];
    
    /**
     * The attributes to log in the Activity Log
     *
     * @var array
     */
    protected static $logAttributes = [
        'name', 'location_id', 'uuid', 'version', 'hostname', 'ip', 'mac_address', 
        'time', 'cover_status', 'error_msg', 'limitsw_open', 'limitsw_closed', 
        'light_in', 'light_out', 'update_rate', 'image_rate', 'sensor_rate', 
        'open_time', 'close_time'
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
     * Get the location for the device
     */
    public function location()
    {
        return $this->belongsTo('App\Location', 'location_id');
    }
    
    /**
     * Get the site for the device using model accessor
     */
    public function getSiteAttribute()
    {
        return $this->location->site ?? (object)[];
    }
    
    /**
     * Accessor: Get the open time of the device converted to hours and minutes
     * If it is a device accessing the time use UTC
     * If it is a user accessing the time use their preferred timezone
     *
     * @param  string $value
     * @return string
     */
    public function getOpenTimeAttribute($value)
    {
        $time = new Carbon($value, 'UTC');
        
        //If the user is logged in then use there preferred timezone
        if (Auth::check())
            $time = $time->setTimezone(Auth::user()->timezone);

        return $time->format('H:i');
    }
    
    /**
     * Accessor: Get the open time of the device converted to the users preferred time and
     * converted to a user friendly format of h:i a
     *
     * @return string
     */
    public function getOpenTimeHumanAttribute()
    {
        $time = new Carbon($this->attributes['open_time'], 'UTC');
        $time = $time->setTimezone(Auth::user()->timezone);
        
        return $time->format('h:i a');
    }
    
    /**
     * Accessor: Get the close time of the device converted to hours and minutes
     * If it is a device accessing the time use UTC
     * If it is a user accessing the time use their preferred timezone
     *
     * @param  string $value
     * @return string
     */
    public function getCloseTimeAttribute($value)
    {
        $time = new Carbon($value, 'UTC');
    
        //If the user is logged in then use there preferred timezone
        if (Auth::check())
            $time = $time->setTimezone(Auth::user()->timezone);
        
        return $time->format('H:i');
    }
    
    /**
     * Accessor: Get the close time of the device converted to the users preferred time and
     * converted to a user friendly format of h:i a
     *
     * @return string
     */
    public function getCloseTimeHumanAttribute()
    {
        $time = new Carbon($this->attributes['close_time'], 'UTC');
        $time = $time->setTimezone(Auth::user()->timezone);
        
        return $time->format('h:i a');
    }
    
    /**
     * Set the open time to UTC
     * If it is a device saving the time use UTC
     * If it is a user saving the time use their preferred timezone
     *
     * @param  string  $value
     * @return void
     */
    public function setOpenTimeAttribute($value)
    {
        //If the user is logged in then use there preferred timezone
        if (Auth::check())
        {
            $time = new Carbon($value, Auth::user()->timezone);
            $time = $time->setTimezone('UTC');
        }
        else
            $time = new Carbon($value, 'UTC');
        
        $this->attributes['open_time'] = $time->format('H:i:s');
    }
    
    /**
     * Set the close time to UTC
     * If it is a device saving the time use UTC
     * If it is a user saving the time use their preferred timezone
     *
     * @param  string  $value
     * @return void
     */
    public function setCloseTimeAttribute($value)
    {
        //If the user is logged in then use there preferred timezone
        if (Auth::check())
        {
            $time = new Carbon($value, Auth::user()->timezone);
            $time = $time->setTimezone('UTC');
        }
        else
            $time = new Carbon($value, 'UTC');
        
        $this->attributes['close_time'] = $time->format('H:i:s');
    }
    
    /**
     * Accessor: Get the last time the server received and update call from the device converted to a
     * user friendly format. The format is Month day 12hour:mins am/pm and will be in the user's preferred timezone
     *
     * @return string
     */
    public function getLastNetworkUpdateAtHumanAttribute()
    {
        return $this->last_network_update_at->setTimezone(Auth::user()->timezone)->format('M j g:i a');
    }
    
    /**
     * Accessor: Get the last time the server received and update call from the device converted to a
     * user friendly detailed format. The format is Month day, year 12hour:mins am/pm and will be in the user's preferred timezone
     *
     * @return string
     */
    public function getLastNetworkUpdateAtDetailedAttribute()
    {
        return $this->last_network_update_at->setTimezone(Auth::user()->timezone)->format('M j, Y g:i a');
    }
    
    /**
     * Accessor: Get the devices last update time converted to a
     * user friendly format. The format is Month day, year 12hour:mins am/pm and will be in the user's preferred timezone
     *
     * @return string
     */
    public function getUpdatedAtHumanAttribute()
    {
        return $this->updated_at->setTimezone(Auth::user()->timezone)->format('M j, Y g:i a');
    }
    
    /**
     * Accessor: Get the devices created at time converted to a
     * user friendly format. The format is Month day, year 12hour:mins am/pm and will be in the user's preferred timezone
     *
     * @return string
     */
    public function getCreatedAtHumanAttribute()
    {
        return $this->updated_at->setTimezone(Auth::user()->timezone)->format('M j, Y g:i a');
    }
    
    /**
     * Scope a query to only include devices belonging to a given location
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $location_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByLocation($query, $location_id)
    {
        return $query->where('location_id', $location_id);
    }
    
    /**
     * Scope a query to limit the included columns to only include what is publicly needed to be displayed on the
     * dashboard
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublicDashData($query)
    {
        return $query->select([
            'devices.id',
            'name',
            'location_id',
            'cover_command',
            'cover_status',
            'open_time',
            'close_time',
            'update_rate',
            'image_rate',
            'sensor_rate',
            'last_network_update_at',
            'image.updated_at as image_updated_at',
        ]);
    }
    
    /**
     * Create a new API token for the device.
     */
    public function generateToken()
    {
        $this->token = str_random(60);
        $this->save();
        
        return $this->token;
    }
    
    /**
     * Get a device by uuid
     *
     * @param string $uuid
     * @return Device|Illuminate\Database\Eloquent\Model
     */
    public static function getDeviceByUUID($uuid)
    {
        return self::where('uuid', $uuid)->first();
    }
    
    /**
     * Get the deviceimage record associated with the device.
     */
    public function image()
    {
        return $this->hasOne('App\Deviceimage');
    }
    

    /**
     * Get the sensors associated with the device.
     */
    public function sensors()
    {
        return $this->hasMany('App\Sensor');
    }
    
    /**
     * Get the sensor data associated with the device.
     */
    public function data()
    {
        return $this->hasManyThrough('App\SensorData', 'App\Sensor');
    }
    
    /**
     * Check if the device is ready for a cover command
     *
     * @return boolean
     */
    public function isReadyForCommand()
    {
        return ($this->cover_status == 'open' || $this->cover_status == 'closed' || $this->cover_status == 'locked');
    }
    
    /**
     * Check if the current time is during the devices scheduled time to be open
     *
     * @return boolean
     */
    public function isDuringScheduleOpen()
    {
        $timezone = Auth::user()->timezone;
        //Get the open, close, and current time in the users timezone
        $open_time = new Carbon($this->open_time, $timezone);
        $close_time = new Carbon($this->close_time, $timezone);
        $time_now = Carbon::now($timezone);
    
        //Check if the current time is during the open schedule or not
        if ($time_now->gt($open_time) && $time_now->lt($close_time))
            return true;
        else
            return false;
    }
    
    /**
     * Get the covers actual status based on the current command and the devices status
     *
     * @return string
     */
    public function actualCoverStatus()
    {
        $isOpen = $this->cover_status === 'open';
        $isClosed = $this->cover_status === 'closed';
        $isLocked = $this->cover_status === 'locked';
            
        switch ($this['cover_command'])
        {
            case 'open':
                if ($isOpen)
                    $status = 'open';
                else if ($isLocked)
                    $status = 'unlocking';
                else
                    $status = 'opening';
                break;
            case 'close':
                if ($isClosed)
                    $status = 'closed';
                else if ($isLocked)
                    $status = 'unlocking';
                else
                    $status = 'closing';
                break;
            case 'lock':
                $status = 'locked';
                break;
            default:
                $status = 'error';
        }
    
        if ($this->cover_status === 'error')
            $status = 'error';
        
        return $status;
    }
    
    /**
     * Get the page number of the device for the dashboard device table pagination
     *
     * @param int $limit
     * @return int
     */
    public function dashPageNum($limit)
    {
        $pos = Device::where('location_id', '=', $this->location_id)
            ->where('name', '<=', $this->name)
            ->orderBy('name', 'ASC')
            ->count();
        
        return ceil($pos / $limit);
    }
}
