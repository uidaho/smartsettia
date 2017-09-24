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
        //Get the very first device and its location and site info
        $device = $this->device_m->getFirstDeviceLocSite();
        
        $sites = $this->site_m->getSitesExclude($device->site_id);
        $locations = $this->location_m->getLocsBasedOnSiteExclude($device->site_id, $device->location_id);
        $devices = $this->device_m->select('id', 'name', 'temperature', 'humidity', 'light_in')
                                    ->where('location_id', '=', $device->location_id)
                                    ->get();
        
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
        //Get the very first device and its location and site info
        $device = $this->device_m->getSiteUpdateDevice($site_id);
        
        $sites = $this->site_m->getSitesExclude($site_id);
        $locations = $this->location_m->getLocsBasedOnSiteExclude($site_id, $device->location_id);
        $devices = $this->device_m->select('id', 'name', 'temperature', 'humidity', 'light_in')
                                    ->where('location_id', '=', $device->location_id)
                                    ->get();
        
        return [ 'default_device' => $device, 'devices' => $devices, 'locations' => $locations, 'sites' => $sites ];
    }
    
    /**
     * Return database data about devices, sites, and locations
     *
     * @param int $location_id
     * @param int $site_id
     * @return Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function locationUpdate($location_id, $site_id)
    {
        //Get the very first device and its location and site info
        $device = $this->device_m->getLocationUpdateDevice($location_id, $site_id);
        
        $sites = $this->site_m->getSitesExclude($site_id);
        $locations = $this->location_m->getLocsBasedOnSiteExclude($site_id, $device->location_id);
        $devices = $this->device_m->select('id', 'name', 'temperature', 'humidity', 'light_in')
                                    ->where('location_id', '=', $device->location_id)
                                    ->get();
        
        return [ 'default_device' => $device, 'devices' => $devices, 'locations' => $locations, 'sites' => $sites ];
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
