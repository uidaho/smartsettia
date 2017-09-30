<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Location extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'site_id'
    ];
    
    /**
     * Update the updated_at and created_at timestamps?
     *
     * @var array
     */
    public $timestamps = true;
    
    /**
     * Get the site for the location
     */
    public function site()
    {
        return $this->belongsTo('App\Site', 'site_id');
    }
    
    /**
     * Get devices for the location
     */
    public function devices()
    {
        return $this->hasMany('App\Device');
    }
    
    /**
     * Get all the locations with the supplied site id
     *
     * @param int $site_id
     * @return Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getLocationsBasedOnSite($site_id)
    {
        return self::where('site_id', $site_id)->get();
    }
    
    /**
     * Get all the locations with the supplied site id except for the location with the supplied id
     *
     * @param int $site_id
     * @param int $location_id
     * @return Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getLocsBasedOnSiteExclude($site_id, $location_id)
    {
        return self::select(['id', 'name'])
                        ->where('site_id', '=', $site_id)
                        ->where('id', '!=', $location_id)
                        ->orderBy('name')->get();
    }
    
    /**
     * Get the locations that are related to the supplied site id and sort the locations
     * starting with the supplied location id
     *
     * @param int $site_id
     * @param int $location_id
     * @return Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function orderedSiteLocationsBy($site_id, $location_id)
    {
        $locations = self::query()->select(['id', 'name'])
                                    ->where('site_id', '=', $site_id)
                                    ->orderByRaw(DB::raw("(id = " . $location_id . ") DESC"))
                                    ->get();
        return $locations;
    }
    
    /**
     * Create a new location and return its id
     *
     * @param string $name
     * @param int $site_id
     * @return int $id
     */
    public function createLocation($name, $site_id)
    {
        $location = new Location;
        $location->name = $name;
        $location->site_id = $site_id;
        $location->save();
        
        return $location->id;
    }
}
