<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @return \Yajra\DataTables\Engines\BaseEngine
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->editColumn('name', function(User $user) {
                return '<a href="' . route('user.show', $user->id) . '">'. $user->name . '</a>';
            })

            ->editColumn('role', function(User $user) {
                return $user->roleString();
            })
            ->addColumn('action', 'user.action')
            ->blacklist([ 'action' ])
            ->rawColumns([ 'name', 'action' ])
            ->setRowData([
                    'data-id' => function($user) {
                        return 'row-'.$user->id;
                    },
                    'data-name' => function($user) {
                        return 'row-'.$user->name;
                    },
            ]);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = User::query();
        
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
                    //->addAction(['width' => '160px'])
                    ->parameters([
                        'dom'     => 'Bfrtip',
                        'order'   => [ [ 0, 'asc' ] ],
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
            'email',
            'phone',
            'role',
            'created_at',
            'updated_at',
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
        return 'users_'.time();
    }
}
