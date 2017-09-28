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
        'name', 'location_id', 'uuid', 'version', 'hostname', 'ip', 'mac_address', 
        'time', 'cover_status', 'error_msg', 'limitsw_open', 'limitsw_closed', 
        'light_in', 'light_out', 'cpu_temp', 'temperature', 'humidity', 
        'update_rate', 'image_rate', 'sensor_rate'
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
    
    /**
     * Get the very first device and its location and site info based on location id and site id
     *
     * @param int $location_id
     * @param int $site_id
     * @return Device|Illuminate\Database\Eloquent\Model
     */
    public function getLocationUpdateDevice($location_id, $site_id)
    {
        return self::select(
                'devices.id as id',
                        'devices.name as name',
                        'devices.location_id',
                        'locations.name as location_name',
                        'sites.id as site_id',
                        'sites.name as site_name',
                        'devices.temperature as temperature',
                        'devices.humidity as humidity',
                        'devices.light_in as light_in',
                        DB::raw('DATE_FORMAT(open_time, "%H:%i") as open_time'),
                        DB::raw('DATE_FORMAT(close_time, "%H:%i") as close_time')
                    )
                    ->leftJoin('locations', 'devices.location_id', '=', 'locations.id')
                    ->leftJoin('sites', 'locations.site_id', '=', 'sites.id')
                    ->where('sites.id', '=', $site_id)
                    ->where('locations.id', '=', $location_id)
                    ->orderBy('devices.id', 'ASC')
                    ->firstOrFail();
    }
    
    /**
     * Get the very first device and its location and site info based on location id and site id
     *
     * @param int $site_id
     * @return Device|Illuminate\Database\Eloquent\Model
     */
    public function getSiteUpdateDevice($site_id)
    {
        return self::select(
                'devices.id as id',
                        'devices.name as name',
                        'devices.location_id',
                        'locations.name as location_name',
                        'sites.id as site_id',
                        'sites.name as site_name',
                        'devices.temperature as temperature',
                        'devices.humidity as humidity',
                        'devices.light_in as light_in',
                        DB::raw('DATE_FORMAT(open_time, "%H:%i") as open_time'),
                        DB::raw('DATE_FORMAT(close_time, "%H:%i") as close_time')
                    )
                    ->leftJoin('locations', 'devices.location_id', '=', 'locations.id')
                    ->leftJoin('sites', 'locations.site_id', '=', 'sites.id')
                    ->where('sites.id', '=', $site_id)
                    ->orderBy('devices.id', 'ASC')
                    ->firstOrFail();
    }
    
    /**
     * Get the very first device and its location and site info
     *
     * @return Device|Illuminate\Database\Eloquent\Model
     */
    public function getFirstDeviceLocSite()
    {
        return self::select(
                'devices.id as id',
                        'devices.name as name',
                        'devices.location_id',
                        'locations.name as location_name',
                        'sites.id as site_id',
                        'sites.name as site_name',
                        'devices.temperature as temperature',
                        'devices.humidity as humidity',
                        'devices.light_in as light_in',
                        DB::raw('DATE_FORMAT(open_time, "%H:%i") as open_time'),
                        DB::raw('DATE_FORMAT(close_time, "%H:%i") as close_time')
                    )
                    ->leftJoin('locations', 'devices.location_id', '=', 'locations.id')
                    ->leftJoin('sites', 'locations.site_id', '=', 'sites.id')
                    ->orderBy('devices.id', 'ASC')
                    ->firstOrFail();
    }
}
