<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Device extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'location_id'
    ];
    
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
}
