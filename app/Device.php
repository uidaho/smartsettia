<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
