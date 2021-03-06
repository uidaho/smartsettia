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
     * @param SensorDataDataTable $dataTable
     * @return Response
     */
    public function index(SensorDataDataTable $dataTable)
    {
        $this->authorize('index', SensorData::class);
        
        return $dataTable->render('sensordata.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('create', SensorData::class);
        
        return view('sensordata.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->authorize('store', SensorData::class);
        
        request()->validate([
            'sensor_id' => 'required|integer|digits_between:1,10|exists:sensors,id',
            'value' => 'required|max:190|value_string'
        ]);

        $sensorData = SensorData::create($request->all());

        return redirect()->route('sensordata.show', $sensorData->id)
            ->with('success', 'SensorData created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  String  $id
     * @return Response
     */
    public function show($id)
    {
        $this->authorize('show', SensorData::class);
        
        $sensorData = SensorData::findOrFail($id);
        return view('sensordata.show', [ 'sensordata' => $sensorData ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  String  $id
     * @return Response
     */
    public function edit($id)
    {
        $this->authorize('edit', SensorData::class);
        
        $sensorData = SensorData::findOrFail($id);
        return view('sensordata.edit', [ 'sensordata' => $sensorData ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  String  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('update', SensorData::class);
        
        request()->validate([
            'sensor_id' => 'required|integer|digits_between:1,10|exists:sensors,id',
            'value' => 'required|max:190|value_string'
        ]);
        $query = SensorData::findOrFail($id)->update($request->all());
        return redirect()->route('sensordata.show', $id)
            ->with('success', 'SensorData updated successfully');    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  String  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->authorize('destroy', SensorData::class);
        
        SensorData::findOrFail($id)->delete();
        return redirect()->route('sensordata.index')
            ->with('success', 'SensorData deleted successfully');
    }

}
