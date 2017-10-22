<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\LocationDataTable;
use App\Location;

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
        return view('location.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'site_id' => 'required|integer|digits_between:1,10|exists:sites,id',
            'name' => 'required|string|max:75',
        ]);
    
        $location = Location::create($request->all());
    
        return redirect()->route('location.show', $location->id)
            ->with('success', 'Location created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $location = Location::findOrFail($id);
        $devices = $location->devices()->orderBy('name', 'ASC')->paginate(15);
    
        return view('location.show', [ 'location' => $location, 'devices' => $devices ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $location = Location::findOrFail($id);
    
        return view('location.edit', [ 'location' => $location ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'site_id' => 'required|integer|digits_between:1,10|exists:sites,id',
            'name' => 'required|string|max:75',
        ]);
        
        Location::findOrFail($id)->update($request->all());
        
        return redirect()->route('location.show', $id)
            ->with('success', 'Location updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Location::findOrFail($id)->delete();
        return redirect()->route('location.index')
            ->with('success','Location deleted successfully');
    }
}
