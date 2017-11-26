<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\DataTables\ActivityLogDataTable;

class ActivityLogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display index page and process dataTable ajax request.
     *
     * @param ActivityLogDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(ActivityLogDataTable $dataTable)
    {
        return $dataTable->render('activitylog.index');
    }

}
