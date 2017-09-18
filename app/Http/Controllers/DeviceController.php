<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\DataTables\DevicesDataTable;
use App\Device;
use App\Site;
use App\Location;

class DeviceController extends Controller
{
    private $device_m = null;
    private $site_m = null;
    private $location_m = null;
    
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        // TODO: Setup logging
        // $this->middleware('log')->only('index');
    
        $this->device_m = new Device();
        $this->site_m = new Site();
        $this->location_m = new Location();
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
        $device = $this->device_m->findOrFail($id);

        return view('device.show', [ 'device' => $device ]);
    }

    /**
     * View the edit device page.
     *
     * @param  string  $id
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $device = $this->device_m->findOrFail($id);
        
        $location = $this->location_m->find($device->location_id);
        if ($location)
        {
            $sites = $this->site_m->orderedSitesBy($location->site_id);
            $locations = $this->location_m->orderedSiteLocationsBy($location->site_id, $device->location_id);
        }
        else
        {
            $locations = null;
            $sites = $this->site_m->all();
        }

        return view('device.edit', [ 'device' => $device, 'locations' => $locations, 'sites' => $sites ]);
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
     * Update the given device.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // TODO: Since HTML forms can't make PUT, PATCH, or DELETE requests, you will need
        // to add a hidden  _method field to spoof these HTTP verbs. The
        // method_field helper can create this field for you:
        // {{ method_field('PUT') }}

        $device = $this->device_m->findOrFail($id);
        $oldLocationID = $device->location_id;
        $location = null;
        $site = null;

        // TODO figure out way for unique location names for each specific site
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'site' => 'required_without:new_site_name|int|max:255|nullable',
            'new_site_name' => 'required_without:site|unique:sites,name|nullable',
            'location' => 'required_without:new_location_name|int|max:255|nullable',
            'new_location_name' => 'required_without:location|unique:locations,name|string|max:255|nullable',
        ]);
        
        if ($validator->fails()) {
            return redirect('device/'.$id.'/edit')->withErrors($validator)->withInput();
        }
        
        $siteNew = !empty($request->input('new_site_name'));
        //Get the site id of the old or newly created site
        if ($siteNew)
        {
            //Create a new site
            $siteName = $request->input('new_site_name');
            $site_id = $this->site_m->createSite($siteName);
        }
        else
        {
            $site_id = $request->input('site');
        }
        
        $locationNew = !empty($request->input('new_location_name'));
        //Get the location id of the old or newly created location
        if ($locationNew)
        {
            //Create a new location
            $locationName = $request->input('new_location_name');
            $location_id = $this->location_m->createLocation($locationName, $site_id);
        }
        else
        {
            $location_id = $request->input('location');
        }
        
        //Update the devices name and location_id
        $device->location_id = $location_id;
        $device->name = $request->input('name');
        $device->save();

        //If the old site isn't connected to a device then remove it
        $this->removeUnusedSite($oldLocationID);
        
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
        $device = $this->device_m->findOrFail($id);

        if ($device->trashed())
        {
            //If the user was already deleted then permanently delete it
            $this->device_m->destroy($id);
        }
        else
        {
            //Remove the location from the device
            $oldLocation_id = $device->location_id;
            $this->device_m->updateLocationID($id, null);
            //Remove unused location and site if applicable
            $this->removeUnusedSite($oldLocation_id);
            
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
        $device = $this->device_m->findOrFail($id);
        
        return view('device.remove', [ 'device' => $device ]);
    }
    
    /**
     * Delete the location with the supplied id if it is not used by any devices
     *
     * @param  int $oldLocationID
     */
    private function removeUnusedSite($oldLocationID)
    {
        //Cleanup left over sites and locations
        $noDevice = empty($this->device_m->getFirstDeviceBasedOnLocation($oldLocationID));
        if ($noDevice && $oldLocationID != null)
        {
            $oldLocation = $this->location_m->findOrFail($oldLocationID);
            $site_id = $oldLocation->site_id;
            $locations = $this->location_m->getLocationsBasedOnSite($site_id);
            if (sizeof($locations) == 1)
            {
                //Get the site connected to the location and delete it
                $this->site_m->findOrFail($site_id)->delete();
            }
            else
            {
                //Delete the location that isn't used anymore
                $oldLocation->delete();
            }
        }
    }
}
