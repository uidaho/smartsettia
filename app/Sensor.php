<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
    public function getLatestDataAttribute()
    {
        return $this->hasOne('App\SensorData')->latest()->first() ?? (object)[];
    }
    
    /**
     * Get the last hour's sensor data averaged by the minute for the sensor.
     */
    public function getLastHourMinutelyAvgDataAttribute()
    {
        return $this->hasMany('App\SensorData')
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') AS date, AVG(value) AS value")
            ->whereRaw("created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)")
            ->groupBy("date")
            ->get();
    }
    
    /**
     * Get the last day's sensor data averaged hourly for the sensor.
     */
    public function getLastDayHourlyAvgDataAttribute()
    {
        return $this->hasMany('App\SensorData')
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H') AS date, AVG(value) AS value")
            ->whereRaw("created_at > DATE_SUB(NOW(), INTERVAL 1 DAY)")
            ->groupBy("date")
            ->get();
    }
    
    /**
     * Get the last weeks's sensor data averaged daily for the sensor.
     */
    public function getLastWeekDailyAvgDataAttribute()
    {
        return $this->hasMany('App\SensorData')
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d') AS date, AVG(value) AS value")
            ->whereRaw("created_at > DATE_SUB(NOW(), INTERVAL 7 DAY)")
            ->groupBy("date")
            ->get();
    }
    
    /**
     * Get the last months's sensor data averaged daily for the sensor.
     */
    public function getLastMonthDailyAvgDataAttribute()
    {
        return $this->hasMany('App\SensorData')
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d') AS date, AVG(value) AS value")
            ->whereRaw("created_at > DATE_SUB(NOW(), INTERVAL 30 DAY)")
            ->groupBy("date")
            ->get();
    }
    
    /**
     * Get the last year's sensor data averaged monthly for the sensor.
     */
    public function getLastYearMonthlyAvgDataAttribute()
    {
        return $this->hasMany('App\SensorData')
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') AS date, AVG(value) AS value")
            ->whereRaw("created_at > DATE_SUB(NOW(), INTERVAL 1 YEAR)")
            ->groupBy("date")
            ->get();
    }
}