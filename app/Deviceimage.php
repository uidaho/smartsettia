<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;
use Carbon\Carbon;

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
    protected static $ignoreChangedAttributes = ['updated_at'];
    
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
    
    /**
     * Check if the active device's image is stale by at least 10 minutes and return true if so
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return boolean
     */
    public function scopeIsStale($query)
    {
        //Check if the device has an uploaded image on the server and if it is stale
        $staleImage = $query->where('updated_at', '<=', Carbon::now()->subMinute(10))->first();
        
        if (empty($staleImage))
            $isImageStale = false;
        else
            $isImageStale = true;
        
        return $isImageStale;
    }
}
