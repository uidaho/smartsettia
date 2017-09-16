<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
    
    public $timestamps = false;
    
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
        return $this->hasManyThrough('App\Device', 'App\Location', 'device_id', 'location_id', 'id');
    }
}
