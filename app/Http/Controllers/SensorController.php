<?php 

namespace App\Http\Controllers;

use App\Sensor;
use App\DataTables\SensorDataTable;
use Illuminate\Http\Request;

class SensorController extends Controller 
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
    public function index(SensorDataTable $dataTable)
    {
        return $dataTable->render('sensor.index');
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create()
    {
        return view('sensor.create');
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
        $sensor = Sensor::findOrFail($id);

        return view('sensor.show', [ 'sensor' => $sensor ]);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function edit(Request $request, $id)
    {
        $sensor = Sensor::findOrFail($id);
        
        return view('sensor.edit', [ 'sensor' => $sensor ]);
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
