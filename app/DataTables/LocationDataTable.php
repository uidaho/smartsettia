<?php

namespace App\DataTables;

use Yajra\DataTables\Services\DataTable;
use App\Location;

class LocationDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @return \Yajra\DataTables\Engines\BaseEngine
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->editColumn('name', function ($location) {
                return '<a href="' . route('location.show', $location->id) . '">'. $location->name . '</a>';
            })
            ->editColumn('site_id', function ($location) {
                return '<a href="' . route('site.show', $location->site_id) . '">'. ($location->site->name ?? '') . '</a>';
            })
            ->addColumn('action', 'location.action')
            ->blacklist([ 'action' ])
            ->rawColumns(['site_id', 'name', 'action']);
    }
    
    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Location::query();
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
            [ 'data' => 'site_id', 'name' => 'site_id', 'title' => 'Site' ],
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
            'order'   => [ [ 0, 'asc' ] ],
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
        return 'location_'.time();
    }
}