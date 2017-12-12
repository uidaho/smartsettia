<?php

namespace App\Http\Controllers;

use App\DataTables\LocationDataTable;
use App\Location;
use App\Site;
use App\Http\Requests\EditLocation;

class LocationController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param  LocationDataTable   $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(LocationDataTable $dataTable)
    {
        return $dataTable->render('location.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sites = Site::orderBy('name', 'ASC')->get();
        return view('location.create', [ 'sites' => $sites ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EditLocation $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(EditLocation $request)
    {
        //Get the site id of the old or newly created site
        if (!empty($request->input('new_site_name')))
        {
            //Create a new site
            $site = Site::create([ 'name' => $request->input('new_site_name') ]);
            $site_id = $site->id;
        } else {
                    $site_id = $request->input('site');
        }
    
        $location = Location::create([ 'name' => $request->input('name'), 'site_id' => $site_id ]);
    
        return redirect()->route('location.show', $location->id)
            ->with('success', 'Location created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        $devices = $location->devices()->orderBy('name', 'ASC')->paginate(15);
    
        return view('location.show', [ 'location' => $location, 'devices' => $devices ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        $sites = Site::orderByRaw("id = ? DESC", $location->site_id)->orderBy('name', 'ASC')->get();
    
        return view('location.edit', [ 'location' => $location, 'sites' => $sites ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EditLocation  $request
     * @param  Location $location
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(EditLocation $request, Location $location)
    {
        //Get the site id of the old or newly created site
        if (!empty($request->input('new_site_name')))
        {
            //Create a new site
            $site = Site::create([ 'name' => $request->input('new_site_name') ]);
            $site_id = $site->id;
        } else {
                    $site_id = $request->input('site');
        }
        
        //Update the location with the supplied name and the site
        $location->update([ 'name' => $request->input('name'), 'site_id' => $site_id ]);
        
        return redirect()->route('location.show', $location->id)
            ->with('success', 'Location updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Location $location
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Location $location)
    {
        $location->delete();
        return redirect()->route('location.index')
            ->with('success', 'Location deleted successfully');
    }
}
