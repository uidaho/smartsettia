<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class Location extends Model
{
    use LogsActivity;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'site_id'
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
        'name', 'site_id'
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
