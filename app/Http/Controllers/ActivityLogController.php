<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\DataTables\ActivityLogDataTable;
use \Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;

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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(ActivityLogDataTable $dataTable)
    {
        if (Gate::denies('index-activitylog'))
            throw new AuthorizationException("This action is unauthorized.");
        else
            return $dataTable->render('activitylog.index');
    }

}
