<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'uuid', 'version', 'hostname', 'ip', 'mac_address', 'time', 
        'cover_status', 'error_msg', 'limitsw_open', 'limitsw_closed', 
        'light_in', 'light_out', 'cpu_temp', 'temperature', 'humidity'
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
     * Create a new API token for the device.
     */
    public function generateToken()
    {
        $this->token = str_random(60);
        $this->save();
        
        return $this->token;
    }
}
