<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
//use Spatie\Activitylog\Traits\CausesActivity;

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
        'deleted_at'
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
        'time', 'cover_status', 'error_msg', 'limitsw_open', 'limitsw_closed', 
        'light_in', 'light_out', 'cpu_temp', 'temperature', 'humidity', 
        'update_rate', 'image_rate', 'sensor_rate'
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
        'name', 'location_id', 'uuid', 'version', 'hostname', 'ip', 'mac_address', 
        'time', 'cover_status', 'error_msg', 'limitsw_open', 'limitsw_closed', 
        'light_in', 'light_out', 'cpu_temp', 'temperature', 'humidity', 
        'update_rate', 'image_rate', 'sensor_rate'
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
     * Get the site for the device
     */
    public function site()
    {
        return $this->location->site;
    }
    
    /**
     * Accessor: Get the open time of the device converted to hours and minutes
     *
     * @param  string $value
     * @return string
     */
    public function getOpenTimeAttribute($value)
    {
        $time = new Carbon($value, 'UTC');
        $time = $time->setTimezone(Auth::user()->timezone);
        return $time->format('H:i');
    }
    
    /**
     * Accessor: Get the close time of the device converted to hours and minutes
     *
     * @param  string $value
     * @return string
     */
    public function getCloseTimeAttribute($value)
    {
        $time = new Carbon($value, 'UTC');
        $time = $time->setTimezone(Auth::user()->timezone);
        return $time->format('H:i');
    }
    
    /**
     * Set the open time to UTC
     *
     * @param  string  $value
     * @return void
     */
    public function setOpenTimeAttribute($value)
    {
        $time = new Carbon($value, Auth::user()->timezone);
        $time = $time->setTimezone('UTC');
        $this->attributes['open_time'] = $time;
    }
    
    /**
     * Set the close time to UTC
     *
     * @param  string  $value
     * @return void
     */
    public function setCloseTimeAttribute($value)
    {
        $time = new Carbon($value, Auth::user()->timezone);
        $time = $time->setTimezone('UTC');
        $this->attributes['close_time'] = $time;
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
                            'id',
                            'name',
                            'location_id',
                            'cover_command',
                            'cover_status',
                            'temperature',
                            'humidity',
                            'light_in',
                            'open_time',
                            'close_time',
                            'update_rate',
                            'image_rate',
                            'sensor_rate',
                            'cpu_temp',
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
}
