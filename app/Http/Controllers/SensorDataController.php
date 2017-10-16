<?php 

namespace App\Http\Controllers;

use App\SensorData;
use App\DataTables\SensorDataDataTable;
use Illuminate\Http\Request;

class SensorDataController extends Controller 
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(SensorDataDataTable $dataTable)
    {
        return $dataTable->render('sensordata.index');
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create()
    {
        return view('sensordata.create');
    }

    /**
    * Store a newly created resource in storage.
    *
    * @return Response
    */
    public function store()
    {
    
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function show(Request $request, $id)
    {
        $sensordata = SensorData::findOrFail($id);

        return view('sensordata.show', [ 'sensordata' => $sensordata ]);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function edit(Request $request, $id)
    {
        $sensordata = SensorData::findOrFail($id);
        
        return view('sensordata.edit', [ 'sensordata' => $sensordata ]);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function update($id)
    {
    
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy($id)
    {
    
    }

}
