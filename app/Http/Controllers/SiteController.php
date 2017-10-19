<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\SiteDataTable;
use App\Site;

class SiteController extends Controller
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
     * @param  SiteDataTable   $dataTable
     * @return Response
     */
    public function index(SiteDataTable $dataTable)
    {
        return $dataTable->render('site.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('site.create');
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
            'name' => 'required|string|max:75',
        ]);
        
        $site = Site::create($request->all());
        
        return redirect()->route('site.show', $site->id)
            ->with('success', 'Site created successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $site = Site::findOrFail($id);
        
        return view('site.show', [ 'site' => $site ]);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $site = Site::findOrFail($id);
        
        return view('site.edit', [ 'site' => $site ]);
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
            'name' => 'required|string|max:75',
        ]);
        
        Site::findOrFail($id)->update($request->all());
        
        return redirect()->route('site.show', $id)
            ->with('success', 'Site updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Site::findOrFail($id)->delete();
        return redirect()->route('site.index')
            ->with('success','Site deleted successfully');
    }
}
