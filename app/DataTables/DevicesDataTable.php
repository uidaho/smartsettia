<?php

namespace App\DataTables;

use App\Device;
use App\Site;
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
            ->addColumn('action', 'device.action')
            ->blacklist([ 'action'])
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
        $query = Device::select([
                            'devices.id as id',
                            'devices.name as name',
                            'locations.name as location',
                            'sites.name as site',
                            'open_time',
                            'close_time',
                        ])
                        ->selectRaw('CONCAT(update_rate, "/", image_rate, "/", sensor_rate) as rates')
                        ->leftJoin('locations', 'devices.location_id', '=', 'locations.id')
                        ->leftJoin('sites', 'locations.site_id', '=', 'sites.id');
    
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
            [ 'name' => 'id', 'data' => 'id', 'title' => 'ID', 'render' => null, 'searchable' => true, 'orderable' => true, 'exportable' => true, 'printable' => true, 'footer' => '' ],
            [ 'name' => 'name', 'data' => 'name', 'title' => 'Name', 'render' => null, 'searchable' => true, 'orderable' => true, 'exportable' => true, 'printable' => true, 'footer' => '' ],
            [ 'name' => 'location', 'data' => 'location', 'title' => 'Location', 'render' => null, 'searchable' => false, 'orderable' => true, 'exportable' => true, 'printable' => true, 'footer' => '' ],
            [ 'name' => 'site', 'data' => 'site', 'title' => 'Site', 'render' => null, 'searchable' => false, 'orderable' => true, 'exportable' => true, 'printable' => true, 'footer' => '' ],
            [ 'name' => 'open_time', 'data' => 'open_time', 'title' => 'Open Time', 'render' => null, 'searchable' => false, 'orderable' => true, 'exportable' => true, 'printable' => true, 'footer' => '' ],
            [ 'name' => 'close_time', 'data' => 'close_time', 'title' => 'Close Time', 'render' => null, 'searchable' => false, 'orderable' => true, 'exportable' => true, 'printable' => true, 'footer' => '' ],
            [ 'name' => 'rates', 'data' => 'rates', 'title' => 'U/I/S Rates', 'render' => null, 'searchable' => false, 'orderable' => true, 'exportable' => true, 'printable' => true, 'footer' => '' ],
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
