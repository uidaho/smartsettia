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
     * Get the site for the location
     */
    public function location()
    {
        return $this->belongsTo('App\Location');
    }
}
