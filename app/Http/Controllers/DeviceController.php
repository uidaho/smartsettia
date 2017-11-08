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
use Charts;

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
        return view('device.index');
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
        
        $charts = [];
        foreach ($device->sensors as $sensor) {
            $charts[$sensor->id] = Charts::create('line', 'highcharts')
                ->title($sensor->name)
                ->elementLabel($sensor->type)
                ->labels($sensor->last_week_daily_avg_data->pluck('date'))
                ->values($sensor->last_week_daily_avg_data->pluck('value'))
                ->responsive(true);
        }
        
        return view('device.show', [ 'device' => $device, 'charts' => $charts ]);
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
        $device = Device::findOrFail($id);
        //Get the devices location
        $location = $device->location()->select('id', 'name', 'site_id')->first();
    
        //Get the site id and location id if they exist and if not assign 0
        $site_id = $location->site_id ?? 0;
        $location_id = $location->id ?? 0;
    
        //Get all sites with the current site first
        $sites = Site::select('id', 'name')->orderByRaw("id = ? DESC", $site_id)
            ->orderBy('name', 'ASC')->get();
        //Get all locations for the selected site with the selected location first
        $locations = Location::select('id', 'name')->where('site_id', '=', $sites[0]->id ?? 0)
            ->orderByRaw("id = ? DESC", $location_id)->orderBy('name', 'ASC')->get();
        
        return view('device.edit', [ 'device' => $device, 'locations' => $locations, 'sites' => $sites ]);
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
        
        //Get the site id of the old or newly created site
        if (!empty($request->input('new_site_name')))
        {
            //Create a new site
            $site = Site::create(['name' => $request->input('new_site_name')]);
            $site_id = $site->id;
        }
        else
            $site_id = $request->input('site_id');
        
        //Get the location id of the old or newly created location
        if (!empty($request->input('new_location_name')))
        {
            //Create a new location
            $location = Location::create(['name' => $request->input('new_location_name'), 'site_id' => $site_id]);
            $location_id = $location->id;
        }
        else
            $location_id = $request->input('location_id');
        
        //Update the device
        $device->location_id = $location_id;
        $device->name = $request->input('name');
        $device->open_time = $request->input('open_time');
        $device->close_time = $request->input('close_time');
        $device->update_rate = $request->input('update_rate');
        $device->image_rate = $request->input('image_rate');
        $device->sensor_rate = $request->input('sensor_rate');
        //Check if the cover_command needs to be updated
        if ($request->input('command') != null)
        {
            //If device is currently opening, closing or in an error state don't update command
            if (!$device->isReadyForCommand())
                return response()->json("Device is currently in use.", 403);
    
            $command = $request->input('command');
            
            //If command is to unlock the device then check if the device should be open or closed based on the schedule
            if ($request->command === 'unlock')
            {
                if ($device->isDuringScheduleOpen())
                    $command =  'open';
                else
                    $command =  'close';
            }
            $device->cover_command = $command;
        }
        
        $device->save();
    
        if (\Request::ajax())
            return response()->json(['success' => 'Device updated successfully']);
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

        if ($device->trashed())
        {
            //If the device was already deleted then permanently delete it
            $device->forceDelete($device->id);
        }
        else
        {
            //Remove the location from the device
            $device->location_id = null;
            $device->save();
            
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
