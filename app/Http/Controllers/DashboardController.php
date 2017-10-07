<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Device;
use App\Site;
use App\Location;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
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
        $device = Device::publicDashData()->first();
        //Get the devices location
        $location = $device->location()->select('id', 'name', 'site_id')->firstOrFail();
        //Get the devices site
        $site = $location->site()->select('id', 'name')->firstOrFail();
    
        $data = $this->dashData($site, $location, $device);
        
        return view('dashboard.index', [ 'active_device' => $data[0], 'devices' => $data[1], 'locations' => $data[2], 'sites' => $data[3] ]);
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
    
    /**
     * Refresh all the data on the dashboard except the image and sensor graphs
     *
     * @param  Request  $request
     * @return Response
     */
    public function ajaxRefreshAll(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_id' => 'required|int|max:255',
            'location_id' => 'required|int|max:255',
            'device_id' => 'required|int|max:255',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }
        
        //Todo limit the amount of queries based on if there is changes
        //Check for changes in database since last update
        //where('created_at', '>=', Carbon::now()->subDay())->get();
    
        //Get the given site
        $site = Site::select('id', 'name')->find($request->site_id);
        //Get the given location
        $location = Location::select('id', 'name', 'site_id')->find($request->location_id);
        //Get the given device if it is still at the same location
        $device = Device::publicDashData()->where('location_id', '=', $request->location_id)->find($request->device_id);
        
        if (empty($site))                 //Check if the site still exists
        {
            //Get the first site and if no sites exist throw an error
            $site = Site::select('id', 'name')->firstOrFail();
            //Get the first location from the site
            $location = $site->locations()->select('id', 'name', 'site_id')->firstOrFail();
            //Get the first device from the location
            $device = $location->devices()->publicDashData()->firstOrFail();
        }
        else if (empty($location))        //Check if the location still exists
        {
            //Get the first location from the given site
            $location = $site->locations()->select('id', 'name', 'site_id')->firstOrFail();
            //Get the first device from the location
            $device = $location->devices()->publicDashData()->firstOrFail();
        }
        else if (empty($device))        //Check if the device still exists at the given location
        {
            //Get the first device from the location
            $device = $location->devices()->publicDashData()->firstOrFail();
        }
        
        $data = $this->dashData($site, $location, $device);
        
        return response()->json([ 'active_device' => $data[0], 'devices' => $data[1], 'locations' => $data[2], 'sites' => $data[3] ]);
    }
    
    /**
     * Return database data about devices, sites, and locations
     *
     * @param int $site_id
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function siteChange($site_id)
    {
        //Get the given site
        $site = Site::select('id', 'name')->findOrFail($site_id);
        //Get the given location
        $location = Location::select('id', 'name', 'site_id')->where('site_id', '=', $site->id)->firstOrFail();
        //Get the given device if it is still at the same location
        $device = Device::publicDashData()->where('location_id', '=', $location->id)->firstOrFail();
        
        $data = $this->dashData($site, $location, $device);
        
        return response()->json([ 'active_device' => $data[0], 'devices' => $data[1], 'locations' => $data[2], 'sites' => $data[3] ]);
    }
    
    /**
     * Return database data about devices, sites, and locations
     *
     * @param int $location_id
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function locationChange($location_id)
    {
        //Get the given location
        $location = Location::select('id', 'name', 'site_id')->findOrFail($location_id);
        //Get the given site
        $site = $location->site()->select('id', 'name')->firstOrFail();
        //Get the given device if it is still at the same location
        $device = Device::publicDashData()->where('location_id', '=', $location_id)->firstOrFail();
        
        $data = $this->dashData($site, $location, $device);
        
        return response()->json([ 'active_device' => $data[0], 'devices' => $data[1], 'locations' => $data[2], 'sites' => $data[3] ]);
    }
    
    /**
     * Return database data about devices, sites, and locations
     *
     * @param \Illuminate\Database\Eloquent\Model $site
     * @param \Illuminate\Database\Eloquent\Model $location
     * @param \Illuminate\Database\Eloquent\Model $device
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function dashData($site, $location, $device)
    {
        //Get all the sites except for the current site ordered by name
        $sites = Site::select('id', 'name')->orderBy('name', 'ASC')->get()->except($site->id);
        
        //Get all the locations for the given site except for the new current location ordered by name
        $locations = $site->locations()->select('id', 'name', 'site_id')->orderBy('name', 'ASC')->get()->except($location->id);
        
        //Get all the devices that belong to the given location ordered by name
        $devices = $location->devices()->publicDashData()->orderBy('name', 'ASC')->get();
        
        $active_device = collect([$device, $location, $site]);
        
        return collect([$active_device, $devices, $locations, $sites]);
    }
}
