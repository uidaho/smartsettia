<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\DataTables\DevicesDataTable;
use App\Device;
use App\Site;
use App\Location;
use Illuminate\Support\Facades\DB;

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
     * @param  Request  $request
     * @param  string  $id
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        $device = Device::findOrFail($id);

        return view('device.show', [ 'device' => $device ]);
    }

    /**
     * View the edit device page.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        $device = Device::findOrFail($id);
        
        $location = Location::where('id', $device->location_id)->first();
        if ($location)
        {
            $sites = Site::query()->select([
                                        'id',
                                        'name',
                                    ])
                                    ->orderByRaw(DB::raw("(id = " . $location->site_id . ") DESC"))
                                    ->get();
            $locations = Location::query()->select([
                                                'id',
                                                'name',
                                            ])
                                            ->where('site_id', '=', $location->site_id)
                                            ->orderByRaw(DB::raw("(id = " . $device->location_id . ") DESC"))
                                            ->get();
        }
        else
        {
            $locations = null;
            $sites = Site::all();
        }

        return view('device.edit', [ 'device' => $device, 'locations' => $locations, 'sites' => $sites ]);
    }
    
    /**
     * View the edit device page.
     *
     * @param  string  $site_id
     * @return
     */
    public function locations($site_id)
    {
        $locations = Location::where('site_id', $site_id)->get();
    
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

        $device = Device::findOrFail($id);
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
            $site = new Site;
            $siteName = $request->input('new_site_name');
            $site->name = $siteName;
            $site->save();
            $site_id = $site->id;
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
            $location = new Location;
            $locationName = $request->input('new_location_name');
            $location->name = $locationName;
            $location->site_id = $site_id;
            $location->save();
            $location_id = $location->id;
        }
        else
        {
            $location_id = $request->input('location');
        }
        
        //Update the devices name and location_id
        $location = Location::where('id', $location_id)
                                    ->where('site_id', $site_id)->first();
        $device->location_id = $location->id;
        $device->name = $request->input('name');
        $device->save();

        //If the old site isn't connected to a device then remove it
        $this->removeUnusedSite($oldLocationID);
        
        return redirect('device');
    }

    /**
     * Deletes a device.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $device = Device::findOrFail($id);

        if ($device->trashed())
        {
            // if the user was already deleted then permananetly delete it
            Device::destroy($id);
        } else
        {
            //Remove the location from the device
            $oldLocation_id = $device->location_id;
            $device->location_id = null;
            $device->save();
            //Remove unused location and site if applicable
            $this->removeUnusedSite($oldLocation_id);
            
            // soft delete the user the first time
            $device->delete();
        }

        return redirect('device');
    }
    
    /**
     * Confirms deletion of a device.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function remove(Request $request, $id)
    {
        $device = Device::findOrFail($id);
        
        return view('device.remove', [ 'device' => $device ]);
    }
    
    /**
     * If a site is not connected to a device then delete the site
     *
     * @param  int $oldLocationID
     */
    private function removeUnusedSite($oldLocationID)
    {
        //Cleanup left over sites and locations
        $deviceExist = Device::where('location_id', '=', $oldLocationID)->first();
        if (!$deviceExist && $oldLocationID != null)
        {
            $site_id = Location::where('id', '=', $oldLocationID)->firstOrFail()->site_id;
            $locations = Location::where('site_id', '=', $site_id)->get();
            if (sizeof($locations) == 1)
            {
                //Get the site connected to the location and delete it
                Site::where('id', '=', $site_id)->delete();
            }
            else
            {
                //Delete the location that isn't used anymore
                Location::where('id', '=', $oldLocationID)->delete();
            }
        }
    }
}
