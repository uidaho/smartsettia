<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Device extends Model
{
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
        'name', 'location_id', 'uuid', 'version', 'hostname', 'ip', 'mac_address', 'time', 
        'cover_status', 'error_msg', 'limitsw_open', 'limitsw_closed', 
        'light_in', 'light_out', 'cpu_temp', 'temperature', 'humidity'
    ];
    
    /**
     * The attributes that are for timestamps.
     *
     * @var array
     */
    public $timestamps = false;
    
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
        return $this->belongsTo('App\Site');
    }
    
    /**
     * Update the device with the matching id with a new location id
     *
     * @param int $id
     * @param int $location_id
     */
    public function updateLocationID($id, $location_id)
    {
        
        $device = $this->findOrFail($id);
        $device->location_id = $location_id;
        $device->save();
    }
    
    /**
     * Get all the devices with the supplied location id
     *
     * @param int $location_id
     * @return Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getDevicesBasedOnLocation($location_id)
    {
        return self::where('location_id', $location_id)->get();
    }
    
    /**
     * Get the first device with the supplied location id
     *
     * @param int $location_id
     * @return Device|Illuminate\Database\Eloquent\Model
     */
    public function getFirstDeviceBasedOnLocation($location_id)
    {
        return self::where('location_id', $location_id)->first();
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
