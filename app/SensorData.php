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
    
    /**
     * Accessor: Get the sensor data's last update time in seconds/minutes/hours since update or converted to user
     * friendly readable format.
     * If the time is less then a day old then display time since it last updated
     * If the time is greater then a day old then display the time in the format of Month day, year 12hour:mins am/pm
     * and using the user's preferred timezone
     *
     *
     * @return string
     */
    public function getUpdatedAtHumanAttribute()
    {
        if ($this->updated_at->diffInDays() > 0) {
                    return $this->updated_at->setTimezone(Auth::user()->timezone)->format('M d, Y h:i a');
        } else {
                    return $this->updated_at->diffForHumans();
        }
    }
    
    /**
     * Accessor: Get the sensor data's creation time in seconds/minutes/hours since update or converted to user
     * friendly readable format.
     * If the time is less then a day old then display time since creation
     * If the time is greater then a day old then display the time in the format of Month day, year 12hour:mins am/pm
     * and using the user's preferred timezone
     *
     *
     * @return string
     */
    public function getCreatedAtHumanAttribute()
    {
        if ($this->created_at->diffInDays() > 0) {
                    return $this->created_at->setTimezone(Auth::user()->timezone)->format('M d, Y h:i a');
        } else {
                    return $this->created_at->diffForHumans();
        }
    }
}