<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Services\DataTableService;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    protected DataTableService $dataTableService;
    protected ActivityLogService $activityLogService;

    public function __construct(DataTableService $dataTableService, ActivityLogService $activityLogService)
    {
        $this->dataTableService = $dataTableService;
        $this->activityLogService = $activityLogService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                'id', 'record_table', 'record_id', 'action', 'ip_address', 'user_agent', 'user_table', 'user_id', 'created_at',
            ];
            $data = ActivityLog::select($columns);
            $response = $this->dataTableService->processDataTable($data, $request, $columns);

            return response()->json($response);
        }

        return view('admin.activity_logs.index');
    }
}
