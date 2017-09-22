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
        //Get the very first device and its location and site info
        $device = $this->device_m->query()
                                    ->select([
                                        'devices.id as id',
                                        'devices.name as name',
                                        'devices.location_id',
                                        'locations.name as location_name',
                                        'sites.id as site_id',
                                        'sites.name as site_name',
                                    ])
                                    ->leftJoin('locations', 'devices.location_id', '=', 'locations.id')
                                    ->leftJoin('sites', 'locations.site_id', '=', 'sites.id')
                                    ->orderBy('devices.id', 'ASC')
                                    ->firstOrFail();
        
        $sites = $this->site_m->orderedSitesBy($device->site_id);
        $locations = $this->location_m->orderedSiteLocationsBy($device->site_id, $device->location_id);
        $devices = $this->device_m->where('location_id', '=', $device->location_id)->get();
        
        return view('dashboard.index', [ 'default_device' => $device, 'devices' => $devices, 'locations' => $locations, 'sites' => $sites ]);
    }
    
    /**
     * Get the locations with the given site id
     *
     * @param  string  $site_id
     * @return Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function locations($site_id)
    {
        $locations = $this->location_m->getLocationsBasedOnSite($site_id);
        
        return $locations;
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
