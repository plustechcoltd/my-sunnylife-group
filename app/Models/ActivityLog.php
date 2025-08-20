<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityLog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'record_table',
        'record_id',
        'action',
        'ip_address',
        'user_agent',
        'user_table',
        'user_id',
    ];

    protected $appends = ['description'];

    public function getDescriptionAttribute(): string
    {
        // The user who performed the action
        $user = $this->getRecord($this->user_table, $this->user_id);

        // The record on which the action was performed
        $record = $this->getRecord($this->record_table, $this->record_id);

        if (!$user || !$record) {
            return '';
        }

        $action = $this->action;
        $user_table = __("label.tables.$this->user_table");
        $record_table = __("label.tables.$this->record_table");

        // Filter the action to a more human-readable format
        return match ($action) {
            default => __(
                "activity_log.descriptions.$action",
                [
                    'user_table' => $user_table, 'user_name' => $user->activity_log_name,
                    'record_table' => $record_table, 'record_name' => $record->activity_log_name,
                    'record_id' => $this->record_id,
                ]
            ),
            'export' => __(
                "activity_log.descriptions.export",
                ['user_table' => $user_table, 'user_name' => $user->activity_log_name, 'record_table' => $record_table]
            ),
            'import' => __(
                "activity_log.descriptions.import",
                ['user_table' => $user_table, 'user_name' => $user->activity_log_name, 'record_table' => $record_table]
            ),
            // define other custom actions here
        };
    }

    protected function getRecord($table, $id)
    {
        // Get model name from table name
        $model = config("const.models.$table");
        if (class_exists($model)) {
            $query = $model::query();

            // If the record is not found, return a generic record
            // This is useful when the record is deleted and the activity log is still present
            return $query->find($id) ?? new class {
                public string $activity_log_name;

                public function __construct()
                {
                    $this->activity_log_name = __('label.labels.deleted');
                }
            };
        }

        return null;
    }
}
