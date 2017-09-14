<?php

namespace App\DataTables;

use App\User;
use Yajra\Datatables\Services\DataTable;

class UsersDataTable extends DataTable
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
            ->addColumn('action', 'user.action')
            ->blacklist([ 'action' ])
            ->editColumn('role', function(User $user) {
                    $role_en = array(0 => "Registered", 1 => "User", 2 => "Manager", 3 => "Admin");
                    return $role_en[ $user->role ].' ('.$user->role.')'; })
            ->setRowClass(function($user) {
                    return $user->trashed() ? 'alert-danger' : "";
            })
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
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    //->addAction(['width' => '160px'])
                    ->parameters([
                        'dom'     => 'Bfrtip',
                        'order'   => [ [ 0, 'asc' ] ],
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
