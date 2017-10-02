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
     * Scope a query to only include locations belonging to a given site
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $site_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBySite($query, $site_id)
    {
        return $query->where('site_id', $site_id);
    }
    
    /**
     * Create a new location and return it
     *
     * @param string $name
     * @param int $site_id
     * @return Model $location
     */
    public static function createLocation($name, $site_id)
    {
        $location = new Location;
        $location->name = $name;
        $location->site_id = $site_id;
        $location->save();
        
        return $location;
    }
}
