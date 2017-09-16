<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
    
    public $timestamps = false;
    
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
}
