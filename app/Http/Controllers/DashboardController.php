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
                                        'devices.temperature as temperature',
                                        'devices.humidity as humidity',
                                        'devices.light_in as light_in',
                                    ])
                                    ->leftJoin('locations', 'devices.location_id', '=', 'locations.id')
                                    ->leftJoin('sites', 'locations.site_id', '=', 'sites.id')
                                    ->orderBy('devices.id', 'ASC')
                                    ->firstOrFail();
        
        $sites = $this->site_m->orderedSitesBy($device->site_id);
        $locations = $this->location_m->orderedSiteLocationsBy($device->site_id, $device->location_id);
        $devices = $this->device_m->where('location_id', '=', $device->location_id)
                                    ->select('id', 'name', 'temperature', 'humidity', 'light_in')->get();
        
        return view('dashboard.index', [ 'default_device' => $device, 'devices' => $devices, 'locations' => $locations, 'sites' => $sites ]);
    }
    
    /**
     * Show the application dashboard.
     *
     * @param int $site_id
     * @return \Illuminate\Http\Response
     */
    public function indexBySite($site_id)
    {
        //Get the very first device and its location and site info
        $device = $this->device_m->query()
                                    ->select([
                                        'devices.id as id',
                                        'devices.name as name',
                                        'devices.location_id',
                                        'locations.name as location_name',
                                        'sites.id as site_id',
                                        'sites.name as site_name',
                                        'devices.temperature as temperature',
                                        'devices.humidity as humidity',
                                        'devices.light_in as light_in',
                                    ])
                                    ->leftJoin('locations', 'devices.location_id', '=', 'locations.id')
                                    ->leftJoin('sites', 'locations.site_id', '=', 'sites.id')
                                    ->where('sites.id', '=', $site_id)
                                    ->orderBy('devices.id', 'ASC')
                                    ->firstOrFail();
        
        $sites = $this->site_m->orderedSitesBy($site_id);
        $locations = $this->location_m->orderedSiteLocationsBy($site_id, $device->location_id);
        $devices = $this->device_m->where('location_id', '=', $device->location_id)
                                    ->select('id', 'name', 'temperature', 'humidity', 'light_in')->get();
        
        return view('dashboard.index', [ 'default_device' => $device, 'devices' => $devices, 'locations' => $locations, 'sites' => $sites ]);
    }
    
    /**
     * Show the application dashboard.
     *
     * @param int $site_id
     * @return Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function siteUpdate($site_id)
    {
        //Get the very first device and its location and site info
        $device = $this->device_m->query()
                                    ->select([
                                        'devices.id as id',
                                        'devices.name as name',
                                        'devices.location_id',
                                        'locations.name as location_name',
                                        'sites.id as site_id',
                                        'sites.name as site_name',
                                        'devices.temperature as temperature',
                                        'devices.humidity as humidity',
                                        'devices.light_in as light_in',
                                    ])
                                    ->leftJoin('locations', 'devices.location_id', '=', 'locations.id')
                                    ->leftJoin('sites', 'locations.site_id', '=', 'sites.id')
                                    ->where('sites.id', '=', $site_id)
                                    ->orderBy('devices.id', 'ASC')
                                    ->firstOrFail();
        
        $sites = $this->site_m->orderedSitesBy($site_id);
        $locations = $this->location_m->orderedSiteLocationsBy($site_id, $device->location_id);
        $devices = $this->device_m->where('location_id', '=', $device->location_id)
                                    ->select('id', 'name', 'temperature', 'humidity', 'light_in')->get();
        
        return [ 'default_device' => $device, 'devices' => $devices, 'locations' => $locations, 'sites' => $sites ];
    }
    
    /**
     * Show the application dashboard.
     *
     * @param int $location_id
     * @param int $site_id
     * @return Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function locationUpdate($location_id, $site_id)
    {
        //Get the very first device and its location and site info
        $device = $this->device_m->query()
                                    ->select([
                                        'devices.id as id',
                                        'devices.name as name',
                                        'devices.location_id',
                                        'locations.name as location_name',
                                        'sites.id as site_id',
                                        'sites.name as site_name',
                                        'devices.temperature as temperature',
                                        'devices.humidity as humidity',
                                        'devices.light_in as light_in',
                                    ])
                                    ->leftJoin('locations', 'devices.location_id', '=', 'locations.id')
                                    ->leftJoin('sites', 'locations.site_id', '=', 'sites.id')
                                    ->where('sites.id', '=', $site_id)
                                    ->orderBy('devices.id', 'ASC')
                                    ->firstOrFail();
        
        $sites = $this->site_m->orderedSitesBy($site_id);
        $locations = $this->location_m->orderedSiteLocationsBy($site_id, $device->location_id);
        $devices = $this->device_m->where('location_id', '=', $device->location_id)
                                    ->select('id', 'name', 'temperature', 'humidity', 'light_in')->get();
        
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
