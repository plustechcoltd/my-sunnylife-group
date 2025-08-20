<?php

namespace App\Services;

use App\Helpers\UserHelper;
use App\Models\ActivityLog;

class ActivityLogService
{
    public function save(string $recordTable, string $recordId, string $action): ActivityLog
    {
        $activityLog = new ActivityLog();
        $activityLog->record_table = $recordTable;
        $activityLog->record_id = $recordId;
        $activityLog->action = $action;
        $activityLog->ip_address = request()->ip() ?? 'undefined';
        $activityLog->user_agent = request()->userAgent() ?? 'undefined';
        $activityLog->user_table = UserHelper::getAuthTable(auth()->user());
        $activityLog->user_id = auth()->id() ?? null;

        $activityLog->save();

        return $activityLog;
    }
}
