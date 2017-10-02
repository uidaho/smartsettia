<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Device;
use App\Site;
use App\Location;

class DashboardController extends Controller
{
    private $device_m = null;
    private $site_m = null;
    private $location_m = null;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    
        $this->device_m = new Device();
        $this->site_m = new Site();
        $this->location_m = new Location();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Todo use the users preferred device
        //Get the very first device
        $device = $this->device_m->first();
        
        //Get all the sites except for the current site ordered by name
        $sites = $this->site_m->orderBy('name', 'ASC')->get()->except($device->site()->id);
        
        //Get all the locations for the given site except for the current location ordered by name
        $locations = $device->site()->locations()->orderBy('name', 'ASC')->get()->except($device->location->id);
        
        //Get all the devices that belong to the given location ordered by name
        $devices = $device->location->devices()->orderBy('name', 'ASC')->get();
        
        return view('dashboard.index', [ 'default_device' => $device, 'devices' => $devices, 'locations' => $locations, 'sites' => $sites ]);
    }
    
    /**
     * Return database data about devices, sites, and locations
     *
     * @param int $site_id
     * @return Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function siteUpdate($site_id)
    {
        //Get the given site
        $site = $this->site_m->findOrFail($site_id);
    
        //Get all the sites except for the current site ordered by name
        $sites = $this->site_m->orderBy('name', 'ASC')->get()->except($site_id);
    
        //Get all the locations for the given site ordered by name
        $locations = $site->locations()->orderBy('name', 'ASC')->get();
        
        //Get the new current location and remove it from $locations
        $location = $locations->pull(0);
    
        //Re-index the collection
        $locations = $locations->values();
    
        //Get all the devices that belong to the given location ordered by name
        $devices = $location->devices()->orderBy('name', 'ASC')->get();
        
        return [ 'location' => $location, 'site' => $site, 'devices' => $devices, 'locations' => $locations, 'sites' => $sites ];
    }
    
    /**
     * Return database data about devices, sites, and locations
     *
     * @param int $location_id
     * @return Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function locationUpdate($location_id)
    {
        //Get the given location
        $location = $this->location_m->findOrFail($location_id);
    
        //Get all the locations for the given site except for the new current location ordered by name
        $locations = $location->site->locations()->orderBy('name', 'ASC')->get()->except($location->id);
    
        //Get all the sites except for the current site ordered by name
        $sites = $this->site_m->orderBy('name', 'ASC')->get()->except($location->site_id);
        
        //Get the current site
        $site = $location->site;
    
        //Get all the devices that belong to the given location ordered by name
        $devices = $location->devices()->orderBy('name', 'ASC')->get();
    
        return [ 'location' => $location, 'site' => $site, 'devices' => $devices, 'locations' => $locations, 'sites' => $sites ];
    }
    
    /**
     * Show the development layouts for dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dev_layout()
    {
        return view('dashboard.dev_layout');
    }
}
