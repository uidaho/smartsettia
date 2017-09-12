<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'location_id'
    ];
    
    /**
     * Get the device's location name
     *
     * @param int $device_id
     * @return string
     */
    public function getLocation($device_id)
    {
        $location_name = DB::table('devices')
            ->select('location.name')
            ->join('locations', 'location_id', '=', 'locations.id')
            ->where('devices.id', $device_id)
            ->get();
        
        return $location_name;
    }
    
    /**
     * Get the device's site name
     *
     * @param int $device_id
     * @return string
     */
    public function getSite($device_id)
    {
        $site_name = DB::table('devices')
            ->select('sites.name')
            ->join('locations', 'location_id', '=', 'locations.id')
            ->join('sites', 'locations.site_id', 'sites.id')
            ->where('devices.id', $device_id)
            ->get();
        
        return $site_name;
    }
}
