<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Facades\Auth;

class Sensor extends Model 
{
    use LogsActivity;

    protected $table = 'sensors';

    /**
     * Update the updated_at and created_at timestamps?
     *
     * @var array
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('device_id', 'name', 'type');

    /**
     * The attributes that are visible.
     *
     * @var array
     */
    protected $visible = array('id', 'device_id', 'name', 'type');

    /**
     * The attributes to log in the Activity Log
     *
     * @var array
     */
    protected static $logAttributes = array('id', 'device_id', 'name', 'type');

    /**
     * Only log those that have actually changed after the update.
     *
     * @var array
     */
    protected static $logOnlyDirty = true;

    /**
     * Get the device associated with the sensor.
     */
    public function device()
    {
        return $this->belongsTo('App\Device');
    }

    /**
     * Get the sensor data associated with the sensor.
     */
    public function data()
    {
        return $this->hasMany('App\SensorData');
    }
    
    /**
     * Get the latest sensor data entry associated with the sensor.
     */
    public function latestData()
    {
        return $this->hasOne('App\SensorData')->latest();
    }
}