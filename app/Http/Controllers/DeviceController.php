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
    }

    /**
     * Display index page and process dataTable ajax request.
     *
     * @param \App\DataTables\DevicesDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(DevicesDataTable $dataTable)
    {
        $trashed = Device::onlyTrashed()->get();
        return $dataTable->render('device.index', compact('trashed'));
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
        $device = Device::findOrFail($id);
        return view('device.show', [ 'device' => $device ]);
    }

    /**
     * View the edit device page
     *
     * @param  string  $id
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        //Get the device with the given id
        $device = Device::publicDashData()->findOrFail($id);
        
        //Get the devices location
        $location = $device->location()->select('id', 'name', 'site_id')->first();
        
        //Check if the selected device has a location
        if (!empty($location))
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
        
        return view('device.edit', [ 'device' => $device, 'locations' => $locations, 'sites' => $sites ]);
    }
    
    /**
     * Get the locations belonging to the given site
     * Return null if the site does not have any locations
     *
     * @param  Site $site
     * @return Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function locations(Site $site)
    {
        $locations = $site->locations;
        
        if ($locations->isEmpty())
            $locations = null;
    
        return response()->json($locations);
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

        // TODO figure out way for unique location names for each specific site
        
        //Get the site id of the old or newly created site
        if (!empty($request->input('new_site_name')))
        {
            //Create a new site
            $site = new Site;
            $site->name = $request->input('new_site_name');
            $site->save();
            
            $site_id = $site->id;
        }
        else
        {
            $site_id = $request->input('site');
        }
        
        //Get the location id of the old or newly created location
        if (!empty($request->input('new_location_name')))
        {
            //Create a new location
            $location = new Location;
            $location->name = $request->input('new_location_name');
            $location->site_id = $site_id;
            $location->save();
            
            $location_id = $location->id;
        }
        else
        {
            $location_id = $request->input('location');
        }
        
        //Update the device
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
            return redirect()->route('device.show', $id)
                ->with('success', 'Device updated successfully');
    }

    /**
     * Deletes a device.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $device = Device::withTrashed()->findOrFail($id);

        if ($device->trashed()) {
            //If the device was already deleted then permanently delete it
            $device->forceDelete($device->id);
        } else {
            //Soft delete the device the first time
            $device->delete();
        }

        return redirect()->route('device.index')
            ->with('success','Device deleted successfully');
    }
    
    /**
     * Restores a device.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $device = Device::onlyTrashed()->findOrFail($id);

        $device->restore();
        
        return redirect()->route('device.show', $device->id)
            ->with('success','Device restored successfully');
    }
}
