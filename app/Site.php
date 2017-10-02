<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
    
    /**
     * Update the updated_at and created_at timestamps?
     *
     * @var array
     */
    public $timestamps = true;
    
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
        return $this->hasManyThrough('App\Device', 'App\Location');
    }
    
    /**
     * Create a new site and return it
     *
     * @param string $name
     * @return Model $site
     */
    public static function createSite($name)
    {
        $site = new Site;
        $site->name = $name;
        $site->save();
        
        return $site;
    }
}
