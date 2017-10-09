<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditDevice;
use Validator;
use Illuminate\Http\Request;
use App\DataTables\DevicesDataTable;
use Illuminate\Support\Facades\Route;
use App\Device;
use App\Site;
use App\Location;

class DeviceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        // TODO: Setup logging
        // $this->middleware('log')->only('index');
    }

    /**
     * Display index page and process dataTable ajax request.
     *
     * @param \App\DataTables\DevicesDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(DevicesDataTable $dataTable)
    {
        return $dataTable->render('device.index');
    }

    /**
     * Show create device page.
     *
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('device.create');
    }

    /**
     * Show the given device.
     *
     * @param  string  $id
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $device = Device::publicDashData()->findOrFail($id);

        return view('device.show', [ 'device' => $device ]);
    }

    /**
     * View the edit device page or the edit device modal
     *
     * @param  string  $id
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        //Get the device with the given id
        $device = Device::publicDashData()->findOrFail($id);
        
        //Get the devices location
        $location = $device->location()->select('id', 'name', 'site_id')->firstOrFail();
        
        //Check if the selected device has a location
        if ($location)
        {
            //Get all the sites except for the current site ordered by name
            $sites = Site::select('id', 'name')->orderBy('name', 'ASC')->get()->except($location->site->id);
            //Get all the locations except for the current location for the given site ordered by name
            $locations = $location->site->locations()->select('id', 'name', 'site_id')->orderBy('name', 'ASC')->get()->except($location->id);
            
            //Add the current site to the front of the collection of sites
            $sites->prepend($location->site);
            //Add the current location to the front of the collection of locations
            $locations->prepend($location);
        }
        else
        {
            //Set locations to null since there is no site or location attached to the selected device
            $locations = null;
            //Get all of the sites
            $sites = Site::all();
        }
        
        if (\Request::ajax())
            return response()->json([ 'device' => $device, 'locations' => $locations, 'sites' => $sites ]);
        else
            return view('device.edit', [ 'device' => $device, 'locations' => $locations, 'sites' => $sites ]);
    }
    
    /**
     * Get the locations with the given site id
     *
     * @param  int $site_id
     * @return Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function locations($site_id)
    {
        $locations = Location::bySite($site_id)->select('id', 'name', 'site_id')->get();
    
        return response()->json($locations);
    }
    
    /**
     * Get the devices details
     *
     * @param  int  $id
     * @return Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function details($id)
    {
        $device = Device::publicDashData()->findOrFail($id);
        
        return response()->json($device);
    }

    /**
     * Update the given device.
     *
     * @param  EditDevice  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(EditDevice $request, $id)
    {
        $device = Device::findOrFail($id);
        $location = null;
        $site = null;

        // TODO figure out way for unique location names for each specific site
        
        //Get the site id of the old or newly created site
        if (!empty($request->input('new_site_name')))
        {
            //Create a new site
            $siteName = $request->input('new_site_name');
            $site_id = Site::createSite($siteName)->id;
        }
        else
        {
            $site_id = $request->input('site');
        }
        
        //Get the location id of the old or newly created location
        if (!empty($request->input('new_location_name')))
        {
            //Create a new location
            $locationName = $request->input('new_location_name');
            $location_id = Location::createLocation($locationName, $site_id)->id;
        }
        else
        {
            $location_id = $request->input('location');
        }
        
        //Update the devices name and location_id
        $device->location_id = $location_id;
        $device->name = $request->input('name');
        $device->open_time = $request->input('open_time');
        $device->close_time = $request->input('close_time');
        $device->update_rate = $request->input('update_rate');
        $device->image_rate = $request->input('image_rate');
        $device->sensor_rate = $request->input('sensor_rate');
        $device->save();

        //Remove any unused sites or locations
        $this->RemoveUnusedSiteLoc();
    
        if (\Request::ajax())
            return response()->json("Success");
        else
            return redirect('device');
    }

    /**
     * Deletes a device.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $device = Device::findOrFail($id);

        if ($device->trashed())
        {
            //If the device was already deleted then permanently delete it
            Device::destroy($id);
        }
        else
        {
            //Remove the location from the device
            $device->location_id = null;
            
            //Remove any unused sites or locations
            $this->RemoveUnusedSiteLoc();
            
            //Soft delete the user the first time
            $device->delete();
        }

        return redirect('device');
    }
    
    /**
     * Confirms deletion of a device.
     *
     * @param  string  $id
     * @return Response
     */
    public function remove($id)
    {
        $device = Device::findOrFail($id);
        
        return view('device.remove', [ 'device' => $device ]);
    }
    
    /**
     * Delete all unused sites and locations
     */
    private function RemoveUnusedSiteLoc()
    {
        //Delete all sites that don't have any devices
        //Locations connected to these sites will automatically be deleted by the database
        Site::doesntHave('devices')->delete();
    
        //Delete all locations that don't have any devices
        Location::doesntHave('devices')->delete();
    }
}
