<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Facades\Auth;

class SensorData extends Model 
{
    //use LogsActivity;

    protected $table = 'sensor_data';

    /**
     * Update the updated_at and created_at timestamps?
     *
     * @var array
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('sensor_id', 'value');

    /**
     * The attributes that are visible.
     *
     * @var array
     */
    protected $visible = array('id', 'sensor_id', 'value', 'created_at', 'updated_at');
    
    /**
     * The attributes to log in the Activity Log
     *
     * @var array
     */
    protected static $logAttributes = array('id', 'sensor_id', 'value', 'created_at', 'updated_at');
    
    /**
     * Only log those that have actually changed after the update.
     *
     * @var array
     */
    protected static $logOnlyDirty = true;

    /**
     * Get the device associated with the sensor.
     */
    public function sensor()
    {
        return $this->belongsTo('App\Sensor');
    }
}