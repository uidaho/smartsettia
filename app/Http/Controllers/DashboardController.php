<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use App\Device;
use App\Site;
use App\Location;
use Carbon\Carbon;

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
        try
        {
            //Todo use the users preferred device
            //Get the first device that doesn't have a null location_id
            $device = Device::publicDashData()->where('location_id', '!=', 'null')->orderBy('id', 'ASC')->first();
        }
        catch(ModelNotFoundException $e)
        {
            //If no device is found then redirect the user to the home page and display a message about registering a device
            return redirect('home')->with('no_devices', 'To access the dashboard page there must be at least one registered device assigned to a location.');
        }
        
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxRefreshAll(Request $request)
    {
        Validator::make($request->all(), [
            'site_id' => 'required|int|max:255',
            'location_id' => 'required|int|max:255',
            'device_id' => 'required|int|max:255',
        ])->validate();
        
        //Todo limit the amount of queries based on if there is changes
        //Check for changes in database since last update
    
        //Get the given site
        $site = Site::select('id', 'name')->find($request->site_id);
        //Get the given location
        $location = Location::select('id', 'name', 'site_id')->find($request->location_id);
        //Get the given device if it is still at the same location
        $device = Device::publicDashData()->where('location_id', '=', $request->location_id)->find($request->device_id);
        
        if (empty($site))                 //Check if the site still exists
        {
            try
            {
                //Get the first site and if no sites exist throw an error
                $site = Site::select('id', 'name')->firstOrFail();
            }
            catch(ModelNotFoundException $e)
            {
                //If no device is found then redirect the user to the home page and display a message about registering a device
                return redirect('home')->with('no_devices', 'To access the dashboard page there must be at least one registered device assigned to a location.');
            }
            
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
        
        //Check if the active device's image is stale by at least 10 minutes
        $isImageStale = $device->image()->isStale();
        
        return response()->json([ 'active_device' => $data[0], 'devices' => $data[1], 'locations' => $data[2], 'sites' => $data[3], 'isImageStale' => $isImageStale ]);
    }
    
    /**
     * Return database data about devices, sites, and locations
     *
     * @param int $site_id
     * @return \Illuminate\Http\JsonResponse
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
    
        //Check if the active device's image is stale by at least 10 minutes
        $isImageStale = $device->image()->isStale();
        
        return response()->json([ 'active_device' => $data[0], 'devices' => $data[1], 'locations' => $data[2], 'sites' => $data[3], 'isImageStale' => $isImageStale ]);
    }
    
    /**
     * Return database data about devices, sites, and locations
     *
     * @param int $location_id
     * @return \Illuminate\Http\JsonResponse
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
    
        //Check if the active device's image is stale by at least 10 minutes
        $isImageStale = $device->image()->isStale();
        
        return response()->json([ 'active_device' => $data[0], 'devices' => $data[1], 'locations' => $data[2], 'sites' => $data[3], 'isImageStale' => $isImageStale ]);
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
    
    /**
     * Open or close the given device
     *
     * @param  Request  $request
     * @param Device $device
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function updateCommand(Request $request, Device $device)
    {
        Validator::make($request->all(), [
            'command' => 'required|string|max:1|in:1,2,3',
        ])->validate();
        
        //Check that device isn't currently in use or has an error
        if ($device->cover_status === 'opening' || $device->cover_status === 'closing' || $device->cover_status === 'error')
            return response()->json("Device is currently in use.", 403);
        
        //1 = open, 2 = close, 3 = lock
        switch($request->command)
        {
            case 1:
                $device->cover_command = 'open';
                break;
            case 2:
                $device->cover_command = 'close';
                break;
            case 3:
                $device->cover_command = $this->disableCommand($device);
                break;
        }
        
        $device->save();
        
        return response()->json("Success");
    }
    
    /**
     * Get the devices command based on the device being locked or unlocked
     *
     * @param Device $device
     * @return string
     */
    public function disableCommand(Device $device)
    {
        //Check if the device is already locked or not
        if ($device->cover_command === 'lock')
        {
            //Get the open, close, and current time in the users timezone
            $open_time = new Carbon($device->open_time, Auth::user()->timezone);
            $close_time = new Carbon($device->close_time, Auth::user()->timezone);
            $time_now = Carbon::now(Auth::user()->timezone);
            
            //Check if the current time is during the open schedule or not
            if (($time_now > $open_time) && ($time_now < $close_time))
                $command =  'open';
            else
                $command =  'close';
        }
        else
            $command =  'lock';
        
        return $command;
    }
}
