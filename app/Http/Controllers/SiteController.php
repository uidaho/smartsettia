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
        $this->authorize('index', Site::class);
        
        return $dataTable->render('site.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Site::class);
        
        return view('site.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('store', Site::class);
        
        $request->validate([
            'name' => 'required|min:2|max:190|name|unique:sites,name',
        ]);
        
        $site = Site::create([ 'name' => $request->name ]);
        
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
        $this->authorize('show', Site::class);
        
        $site = Site::findOrFail($id);
        $locations = $site->locations()->orderBy('name', 'ASC')->paginate(15);
    
        if (\Request::ajax()) {
                    return response()->json(['site' => $site, 'locations' => $locations]);
        } else {
                    return view('site.show', [ 'site' => $site, 'locations' => $locations ]);
        }
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('edit', Site::class);
        
        $site = Site::findOrFail($id);
        
        return view('site.edit', [ 'site' => $site ]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Site  $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Site $site)
    {
        $this->authorize('update', Site::class);
        
        $request->validate([
            'name' => 'required|min:2|max:190|name|unique:sites,name,'.$site->id,
        ]);
        
        $site->update([ 'name' => $request->name ]);
        
        return redirect()->route('site.show', $site->id)
            ->with('success', 'Site updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->authorize('destroy', Site::class);
        
        Site::findOrFail($id)->delete();
        return redirect()->route('site.index')
            ->with('success', 'Site deleted successfully');
    }
}
