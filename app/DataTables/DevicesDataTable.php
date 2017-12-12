<?php

namespace App\DataTables;

use App\Device;
use Yajra\DataTables\Services\DataTable;

class DevicesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @return \Yajra\DataTables\Engines\BaseEngine
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->editColumn('name', function($device) {
                return '<a href="'.route('device.show', $device->id).'">'.$device->name.'</a>';
            })
            ->addColumn('location', function($device) {
                return ($device->location->name ?? 'null');
            })
            ->addColumn('site', function($device) {
                return ($device->location->site->name ?? 'null');
            })
            ->addColumn('rates', function($device) {
                return $device->update_rate.'/'.$device->image_rate.'/'.$device->sensor_rate;
            })
            ->editColumn('updated_at', function($device) {
                return (is_object($device->updated_at) ? $device->updatedAtHuman : 'null');
            })
            ->blacklist([ 'location', 'site', 'rates' ])
            ->rawColumns([ 'name' ]);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Device::query();
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
            'location',
            'site',
            'open_time',
            'close_time',
            'rates',
            [ 'data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Updated At' ]
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
            'order'   => [ [ 0, 'asc' ] ],
            'buttons' => [
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
        return 'devices_'.time();
    }
}
