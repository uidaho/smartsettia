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
            ->editColumn('device_id', function ($sensor) {
                return '<a href="/device/' . $sensor->device_id . '">'. ($sensor->device->name ?? '') . '</a>';
            })
            ->editColumn('name', function ($sensor) {
                return '<a href="/sensor/' . $sensor->id . '">'. $sensor->name . '</a>';
            })
            ->addColumn('value', function ($sensor) {
                return $sensor->latest_data->value;
            })
            ->addColumn('action', 'sensor.action')
            ->blacklist([ 'action', 'value'])
            ->rawColumns(['device_id', 'name', 'action']);
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
            [ 'name' => 'device_id', 'data' => 'device_id', 'title' => 'Device', 'render' => null, 'searchable' => true, 'orderable' => false, 'exportable' => true, 'printable' => true, 'footer' => '' ],
            'name',
            'type',
            'value',
            'action'
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
                'export',
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
