<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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
     * @param  Request  $request
     * @return \Illuminate\Http\Response||\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $request->validate([
            'site_id' => 'sometimes|required|integer|digits_between:1,10',
            'location_id' => 'sometimes|required|integer|digits_between:1,10',
            'device_id' => 'sometimes|required|integer|digits_between:1,10',
            'page' => 'sometimes|required|integer|digits_between:1,10',
        ]);
    
        if (count($request->all()) == 0)
        {
            //Get the device, location, and site ids based on the user's preferred device
            $device = Auth::user()->preferredDevice ?? null;
            $location = $device->location ?? null;
            
            //If the location exists then set the pagination page to be where the device is located
            if ($location != null)
                $request->merge([ 'page' => $device->dashPageNum(4) ]);
            $site_id = $location->site_id ?? 0;
            $location_id = $location->id ?? 0;
            $device_id = $device->id ?? 0;
        }
        else
        {
            //Get the active site, location, and device ids
            $site_id = $request->site_id ?? 0;
            $location_id = $request->location_id ?? 0;
            $device_id = $request->device_id ?? 0;
        }
    
        //Get all sites with the selected site first
        $sites = Site::select('id', 'name')
            ->orderByRaw("id = ? DESC", $site_id)
            ->orderBy('name', 'ASC')
            ->get();
        //Get all locations for the selected site with the selected location first
        $locations = Location::select('id', 'name', 'site_id')
            ->where('site_id', '=', $sites[ 0 ]->id ?? 0)
            ->orderByRaw("id = ? DESC", $location_id)
            ->orderBy('name', 'ASC')
            ->get();
        //Get all devices for the selected location
        $devices = Device::publicDashData()
            ->leftJoin('deviceimages as image', 'devices.id', '=', 'image.device_id')
            ->where('location_id', '=', $locations[ 0 ]->id ?? 0)
            ->orderBy('name', 'ASC')
            ->paginate(4);
    
        //Set the active device to the device defined by the given device id
        $active_device = $devices->where('id', $device_id)->first();
        
        //Check if there were devices found
        if (!$devices->isEmpty())
        {
            //If the original device with the given device id was not found
            //Then assign the the first device in the device list as the active device
            if ($active_device == null)
                $active_device = $devices[ 0 ];
        
            //Add an attribute to each device defining if it is stale
            $devices->transform(function($item)
            {
                //Mark the device as stale if the device has missed three updates plus a minute
                $deviceStaleMins = ceil(($item->update_rate * 3) / 60) + 1;
                $item[ 'isDeviceStale' ] = ($item->last_network_update_at <= Carbon::now()->subMinute($deviceStaleMins)) ? true : false;
    
                //Mark the device image as stale if the device has missed three image updates plus a minute
                if ($item->image_updated_at != null)
                {
                    $imageStaleMins = ceil(($item->image_rate * 3) / 60) + 1;
                    $item[ 'isImageStale' ] = ($item->image_updated_at <= Carbon::now()->subMinute($imageStaleMins)) ? true : false;
                }
                else
                    $item[ 'isImageStale' ] = false;
                
                return $item;
            });
        }
    
        //Store the active site, location, and device in a collection
        $active_data = collect([ 'device' => $active_device, 'location' => $locations[ 0 ] ?? null, 'site' => $sites[ 0 ] ?? null ]);
    
        //Use the device_list.blade.php to generate the device table html
        $html_device_table = view('dashboard.device_list', [ 'devices' => $devices, 'active_data' => $active_data ])->render();
        
        if (\Request::ajax()) {
                    return response()->json([ 'active_data' => $active_data, 'devices' => $devices, 'locations' => $locations,
                'sites' => $sites, 'html_device_table' => $html_device_table ]);
        } else {
                    return view('dashboard.index', [ 'active_data' => $active_data, 'devices' => $devices,
                'locations' => $locations, 'sites' => $sites ]);
        }
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
