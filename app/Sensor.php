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
        return $this->hasMany('App\SensorData')->orderBy('id', 'DESC');
    }
    
    /**
     * Get the latest sensor data entry associated with the sensor.
     */
    public function getLatestDataAttribute()
    {
        return $this->hasOne('App\SensorData')->latest()->first() ?? (object)[];
    }
    
    /**
     * Get the last day's sensor data averaged hourly for the sensor.
     */
    public function getLastDayHourlyAvgDataAttribute()
    {
        // SELECT CONCAT(DATE_FORMAT(created_at, '%Y-%m-%d %H'), ':00:00') AS date, AVG(value) FROM sensor_data WHERE sensor_id = 20 AND created_at > DATE_SUB(NOW(), INTERVAL 1 DAY) GROUP BY DATE_FORMAT(created_at, '%Y-%m-%d %H')
        return $this->hasOne('App\SensorData')
            ->selectRaw("CONCAT(DATE_FORMAT(created_at, '%Y-%m-%d %H'), ':00:00') AS date, AVG(value)")
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->groupByRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H')")
            ->get() ?? (object)[];
    }
}