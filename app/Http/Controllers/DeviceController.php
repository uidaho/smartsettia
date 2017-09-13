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

        return view('device.show', ['device' => $device]);
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
            $site = Site::where('id', $location->site_id)->first();
        else
            $site = null;

        return view('device.edit', ['device' => $device, 'location' => $location, 'site' => $site]);
    }

    /**
     * Update the given device.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
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

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'site' => 'string|max:255',
            'location' => 'string|max:255',
        ]);
        
        if ($validator->fails()) {
            return redirect('device/'.$id.'/edit')->withErrors($validator)->withInput();
        }
    
        //Check if the site entered by the user is already created
        $siteExist = Site::where('name', $request->input('site'))->first();
        if (!$siteExist)
        {
            //Create a new site
            $site = new Site;
            $site->name = $request->input('site');
            $site->save();
        }
    
        //Check if the location entered by the user is already created and connected to the same site
        $site = Site::where('name', $request->input('site'))->first();
        $locationExist = Location::where('name', $request->input('location'))->first();
        if (!$locationExist || !$siteExist)
        {
            //Create a new location
            $location = new Location;
            $location->name = $request->input('location');
            $location->site_id = $site->id;
            $location->save();
        }
        
        //Update the devices name and location_id
        $location = Location::where('name', $request->input('location'))
                                    ->where('site_id', $site->id)->first();
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
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $device = Device::findOrFail($id);

        if ($device->trashed())
        {
            // if the user was already deleted then permananetly delete it
            Device::destroy($id);
        }
        else
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
        
        return view('device.remove', ['device' => $device]);
    }
    
    /**
     * If a site is not connected to a device then delete the site
     *
     * @param  int $oldLocationID
     */
    private function removeUnusedSite($oldLocationID)
    {
        //Cleanup left over sites and locations
        $deviceExist = Device::where('location_id', $oldLocationID)->first();
        if (!$deviceExist && $oldLocationID != null)
        {
            $oldLocation = Location::where('id', $oldLocationID)->firstOrFail()->site_id;
            Site::where('id', $oldLocation)->delete();
        }
    }
}
