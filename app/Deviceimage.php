<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Deviceimage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'device_id', 'url'
    ];

    /**
     * Get the device for the image.
     */
    public function device()
    {
        return $this->belongsTo('App\Device');
    }
}
