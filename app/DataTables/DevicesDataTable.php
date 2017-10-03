<?php

namespace App\DataTables;

use App\Device;
use App\Site;
use Yajra\Datatables\Services\DataTable;

class DevicesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @return \Yajra\Datatables\Engines\BaseEngine
     */
    public function dataTable()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'device.action')
            ->blacklist([ 'action' ])
            ->setRowClass(function($device) {
                return $device->trashed() ? 'alert-danger' : "";
            });
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Device::query()
                        ->select([
                            'devices.id as id',
                            'devices.name as name',
                            'locations.name as location',
                            'sites.name as site',
                            'open_time',
                            'close_time',
                            'update_rate',
                            'image_rate',
                            'sensor_rate',
                        ])
                        ->leftJoin('locations', 'devices.location_id', '=', 'locations.id')
                        ->leftJoin('sites', 'locations.site_id', '=', 'sites.id');
    
    
        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    //->minifiedAjax('')
                    //->addAction(['width' => '160px'])
                    ->parameters([
                        'dom'     => 'Bfrtip',
                        'order'   => [ [ 0, 'asc' ] ],
                        'buttons' => [
                            'export',
                            'print',
                            'reset',
                            'reload',
                        ],
                        'paging' => true,
                        'searching' => true,
                        'info' => true,
                        'searchDelay' => 500,
                    ]);
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
            'update_rate',
            'image_rate',
            'sensor_rate',
            [ 'name' => 'action', 'data' => 'action', 'title' => 'Actions', 'render' => null, 'searchable' => false, 'orderable' => false, 'exportable' => false, 'printable' => true, 'footer' => '' ],
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
