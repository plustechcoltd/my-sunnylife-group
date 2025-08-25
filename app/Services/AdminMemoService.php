<?php

namespace App\Services;

use App\Models\AdminMemo;

class AdminMemoService
{
    public function getByRecordModel($record_model, $record_id = null)
    {
        $admin_memo = AdminMemo::where('record_model', $record_model);
        if ($record_id) {
            $admin_memo->where('record_id', $record_id);
        }

        return $admin_memo->get();
    }
}
