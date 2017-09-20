<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $device = $this->device_m->findOrFail(3);
        $location = $this->location_m->findOrFail($device->location_id);
        
        $sites = $this->site_m->orderedSitesBy($location->site_id);
        $locations = $this->location_m->orderedSiteLocationsBy($location->site_id, $device->location_id);
        $devices = $this->device_m->where('location_id', '=', $device->location_id)->get();
        
        return view('dashboard.index', [ 'default_device' => $device, 'devices' => $devices, 'locations' => $locations, 'sites' => $sites ]);
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
