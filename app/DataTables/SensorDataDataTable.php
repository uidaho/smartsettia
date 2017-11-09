<?php

namespace App\DataTables;

use Yajra\DataTables\Services\DataTable;
use App\SensorData;

class SensorDataDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @return \Yajra\DataTables\Engines\BaseEngine
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->addColumn('sensor', function ($sensordata) {
                return '<a href="' . route('sensor.show', $sensordata->sensor_id) . '">'. ($sensordata->sensor->name ?? 'null') . '</a>';
            })
            ->addColumn('device', function ($sensordata) {
                return '<a href="' . route('device.show', $sensordata->sensor->device->id ?? '0') . '">'. ($sensordata->sensor->device->name ?? 'null') . '</a>';
            })
            ->addColumn('action', 'sensordata.action')
            ->blacklist([ 'action'])
            ->rawColumns(['device', 'sensor', 'action']);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = SensorData::query();
        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id',
            [ 'data' => 'sensor', 'name' => 'sensors.id', 'title' => 'Sensor', 'searchable' => false ],
            [ 'data' => 'device', 'name' => 'devices.id', 'title' => 'Device', 'searchable' => false ],
            'value',
            'created_at',
            'updated_at',
            [ 'data' => 'action', 'name' => 'action', 'title' => 'Action', 'searchable' => false, 'orderable' => false, 'exportable' => false, 'printable' => false ]
        ];
    }

    /**
     * Get builder parameters.
     *
     * @return array
     */
    protected function getBuilderParameters()
    {
        return [
            'dom'     => 'Bfrtip',
            'order'   => [ [ 0, 'desc' ] ],
            'buttons' => [
                'create',
                [ 'extend' => 'collection', 'text' => '<i class="fa fa-file-excel-o"></i> Export', 'buttons' => [ 
                    [ 'extend' => 'csv', 'exportOptions' => [ 'modifier' => [ 'search' => true ] ] ],
                    [ 'extend' => 'excel', 'exportOptions' => [ 'modifier' => [ 'search' => true ] ] ],
                ] ],
                [ 'extend' => 'print', 'exportOptions' => [ 'modifier' => [ 'search' => true ] ] ],
                'reset',
                'reload',
            ],
            'paging' => true,
            'searching' => true,
            'info' => true,
            'searchDelay' => 500,
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'sensordata_'.time();
    }
}
