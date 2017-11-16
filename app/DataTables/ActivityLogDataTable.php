<?php

namespace App\DataTables;

use App\User;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Services\DataTable;
use Spatie\Activitylog\Models\Activity;

class ActivityLogDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->editColumn('causer_id', function ($activity) {
                return ($activity->causer_id ? '<a href="/' . ($activity->causer_type == "App\User" ? 'user' : 'device') . '/' . $activity->causer_id . '">' . ($activity->causer->name ?? '') . '</a>' : 'App');
            })
            ->editColumn('subject_id', function ($activity) {
                return ($activity->subject_id ? '<a href="/' . ($activity->subject_type == "App\User" ? 'user' : 'device') . '/' . $activity->subject_id . '">' . ($activity->subject->name ?? '') . '</a>' : 'App');
            })
            ->editColumn('properties', function ($activity) {
                return $activity->properties;
            })
            ->editColumn('created_at', function ($activity) {
                if ($activity->created_at->diffInDays() > 0)
                    return $activity->created_at->setTimezone(Auth::user()->timezone)->format('M d, Y h:i a');
                else
                    return $activity->created_at->diffForHumans();
            })
            ->rawColumns(['causer_id', 'subject_id', 'properties']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $query = Activity::query();
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
            'created_at',
            [ 'name' => 'causer_id', 'data' => 'causer_id', 'title' => 'Actor', 'render' => null, 'searchable' => true, 'orderable' => true, 'exportable' => true, 'printable' => true, 'footer' => '' ],
            [ 'name' => 'description', 'data' => 'description', 'title' => 'Action', 'render' => null, 'searchable' => true, 'orderable' => true, 'exportable' => true, 'printable' => true, 'footer' => '' ],
            [ 'name' => 'subject_id', 'data' => 'subject_id', 'title' => 'Subject', 'render' => null, 'searchable' => true, 'orderable' => true, 'exportable' => true, 'printable' => true, 'footer' => '' ],
            [ 'name' => 'properties', 'data' => 'properties', 'title' => 'Changes', 'render' => null, 'searchable' => true, 'orderable' => false, 'exportable' => true, 'printable' => true, 'footer' => '' ]
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
        return 'activitylog_' . time();
    }
}
