<?php 

namespace App\Http\Controllers;

use App\Sensor;
use App\DataTables\SensorDataTable;
use Illuminate\Http\Request;
use Charts;

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
     * @param  SensorDataTable   $dataTable
     * @return Response
     */
    public function index(SensorDataTable $dataTable)
    {
        $this->authorize('index', Sensor::class);
        
        return $dataTable->render('sensor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('create', Sensor::class);
    
        return view('sensor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->authorize('store', Sensor::class);
    
        request()->validate([
            'device_id' => 'required|integer|digits_between:1,10|exists:devices,id',
            'name' => 'required|min:2|max:190|name',
            'type' => 'required|max:190|type_name'
        ]);

        $query = Sensor::create($request->all());

        return redirect()->route('sensor.show', $query->id)
            ->with('success', 'Sensor created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $this->authorize('show', Sensor::class);
    
        $sensor = Sensor::findOrFail($id);
        $latestData = $sensor->latestData;
        $sensordata = $sensor->data()->orderBy('id', 'desc')->paginate(25);
        $chartSensorData = $sensordata->reverse();
        $chart = Charts::create('line', 'highcharts')
            ->title($sensor->name)
            ->elementLabel($sensor->type)
            ->labels($chartSensorData->pluck('created_at'))
            ->values($chartSensorData->pluck('value'))
            ->responsive(true);

        return view('sensor.show', [ 'sensor' => $sensor, 'latestData' => $latestData, 'sensordata' => $sensordata, 'chart' => $chart ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $this->authorize('edit', Sensor::class);
    
        $sensor = Sensor::findOrFail($id);
        
        return view('sensor.edit', [ 'sensor' => $sensor ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Sensor  $sensor
     * @return Response
     */
    public function update(Request $request, Sensor $sensor)
    {
        $this->authorize('update', Sensor::class);
    
        request()->validate([
            'device_id' => 'required|integer|digits_between:1,10|exists:devices,id',
            'name' => 'required|min:2|max:190|name',
            'type' => 'required|max:190|type_name'
        ]);
        $sensor->update($request->all());
        return redirect()->route('sensor.show', $sensor->id)
            ->with('success', 'Sensor updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->authorize('destroy', Sensor::class);
    
        Sensor::findOrFail($id)->delete();
        return redirect()->route('sensor.index')
            ->with('success', 'Sensor deleted successfully');
    }

}
