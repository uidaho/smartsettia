<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use App\Device;
use App\Site;
use App\Location;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        $site_id = 0;
        $location_id = 0;
        //TODO use the users preferred device
        $device_id = 3;
        
        $myQuery = Device::publicDashData()->where('id', '=', $device_id)->with('location.site')->get();
        if (!$myQuery->isEmpty())
        {
            $site_id = $myQuery[0]->location->site->id;
            $location_id = $myQuery[0]->location->id;
        }
    
        //Get all sites with the selected site first
        $sites = Site::orderByRaw("id = ? DESC", $site_id)->orderBy('name', 'ASC')->get();
        //Get all locations for the selected site with the selected location first
        $locations = Location::where('site_id', '=', $sites[0]->id)->orderByRaw("id = ? DESC", $location_id)->orderBy('name', 'ASC')->get();
        //Get all devices for the selected location
        $devices = Device::publicDashData()->where('location_id', '=', $locations[0]->id)->orderBy('name', 'ASC')->get();
    
        //Get the active device
        $active_device = $devices->where('id', $device_id)->first();
        //Set the active device to the first device in $devices if it is not empty and the original active device wasn't found
        if (!$devices->isEmpty() && $active_device == null)
            $active_device = $devices[0];
    
        //Store the active site, location, and device in a collection
        $active_data = collect([$active_device, $locations[0], $sites[0]]);
        
        return view('dashboard.index', [ 'active_data' => $active_data, 'devices' => $devices, 'locations' => $locations, 'sites' => $sites ]);
    }
    
    /**
     * Show the given device.
     *
     * @param  string  $id
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        return redirect('/dashboard');
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
    public function refreshPage(Request $request)
    {
        $request->validate([
            'site_id' => 'required|integer|digits_between:1,7',
            'location_id' => 'sometimes|required|integer|digits_between:1,7',
            'device_id' => 'sometimes|required|integer|between:-1,1000000000',
            'offset' => 'sometimes|required|integer|digits_between:1,7',
        ]);
    
        //Todo limit the amount of queries based on if there is changes
        //Check for changes in database since last update
        
        //Limit the number of devices to be loaded
        $limit = 4;
        
        //Set the offset for device pagination
        $offset = $request->offset ?? 0;
        
        //Get the active site, location, and device ids
        $site_id = $request->site_id;
        $location_id = $request->location_id;
        $device_id = $request->device_id;
        
        //TODO always have a un-deletable site and location and there will never be an error
        //Get all sites with the selected site first
        $sites = Site::orderByRaw("id = ? DESC", $site_id)->orderBy('name', 'ASC')->get();
        //Get all locations for the selected site with the selected location first
        $locations = Location::where('site_id', '=', $sites[0]->id)->orderByRaw("id = ? DESC", $location_id)->orderBy('name', 'ASC')->get();
        //Get all devices for the selected location
        $devices = Device::publicDashData()->where('location_id', '=', $locations[0]->id)->orderBy('name', 'ASC')->limit($limit)->offset($offset * $limit)->get();
        //Get the total device count for the given location
        $deviceCount = Device::where('location_id', '=', $locations[0]->id)->count();
    
        //Get the active device
        $active_device = $devices->where('id', $device_id)->first();
        //Set the active device to the first device in $devices if it is not empty and the original active device wasn't found
        if (!$devices->isEmpty() && $active_device == null)
            $active_device = $devices[0];
        
        //Store the active site, location, and device in a collection
        $active_data = collect([$active_device, $locations[0], $sites[0]]);
        
        //Get the total amount of pages for pagination
        $page_count = ceil($deviceCount / $limit) - 1;
        
        //Store pagination data
        $pag_data = collect(['offset' => $offset, 'page_count' => $page_count]);
        
        return response()->json([ 'active_data' => $active_data, 'devices' => $devices, 'locations' => $locations, 'sites' => $sites, 'pag_data' => $pag_data]);
    }
}
