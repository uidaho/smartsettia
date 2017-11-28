<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class Deviceimage extends Model
{
    use LogsActivity;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'device_id', 'url'
    ];
    
    /**
     * The attributes to ignore in the Activity Log
     *
     * @var array
     */
    protected static $ignoreChangedAttributes = [ 'updated_at' ];
    
    /**
     * The attributes to log in the Activity Log
     *
     * @var array
     */
    protected static $logAttributes = [
        'device_id', 'url'
    ];
    
    /**
     * Only log those that have actually changed after the update.
     *
     * @var array
     */
    protected static $logOnlyDirty = true;

    /**
     * Get the device for the image.
     */
    public function device()
    {
        return $this->belongsTo('App\Device');
    }
    
    /**
     * Update the updated_at and created_at timestamps?
     *
     * @var array
     */
    public $timestamps = true;
}
