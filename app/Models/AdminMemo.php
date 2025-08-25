<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminMemo extends Model
{
    use SoftDeletes;

    protected $keyType = 'integer';

    protected $fillable = [
        'admin_id', 'record_model', 'record_id', 'description', 'created_at', 'updated_at', 'deleted_at',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo('App\Models\Admin');
    }

    public function saveByParams(string $record_model, int $record_id, string $description, int $user_id = null): void
    {
        $this->record_model = $record_model;
        $this->record_id = $record_id;
        $this->admin_id = $user_id;
        $this->description = $description;
        $this->save();
    }

    public function getFullNameAdminAttribute()
    {
        return optional($this->admin)->full_name;
    }

    public function getAvatarAdminAttribute()
    {
        return optional($this->admin)->avatar_image_path;
    }
}
