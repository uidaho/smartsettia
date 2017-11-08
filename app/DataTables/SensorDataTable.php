<?php

namespace App\DataTables;

use Yajra\DataTables\Services\DataTable;
use App\Sensor;

class SensorDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @return \Yajra\DataTables\Engines\BaseEngine
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->editColumn('name', function ($sensor) {
                return '<a href="' . route('sensor.show', $sensor->id) . '">'. $sensor->name . '</a>';
            })
            ->editColumn('device_id', function ($sensor) {
                return '<a href="' . route('device.show', $sensor->device_id) . '">'. ($sensor->device->name ?? '') . '</a>';
            })
            ->addColumn('value', function ($sensor) {
                return '<a href="' . route('sensordata.show', $sensor->latest_data->id ?? '0') . '">'. ($sensor->latest_data->value ?? 'null') . '</a>';
            })
            ->addColumn('action', 'sensor.action')
            ->blacklist([ 'value', 'action' ])
            ->rawColumns(['device_id', 'name', 'value', 'action']);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Sensor::query();
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
            'name',
            [ 'data' => 'device_id', 'name' => 'device_id', 'title' => 'Device' ],
            'type',
            'value',
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
                'csv',
                'excel',
                'print',
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
        return 'sensor_'.time();
    }
}
