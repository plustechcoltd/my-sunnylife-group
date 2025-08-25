<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Route;

class LocationGroup extends Model
{
    use SoftDeletes;

    protected $keyType = 'integer';

    protected $fillable = ['name', 'sortno', 'created_at', 'updated_at', 'deleted_at'];

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class, 'location_group_id', 'id');
    }

    public function getActivityLogNameAttribute(): string
    {
        if ($this->Trashed()) {
            return __('label.labels.deleted');
        }

        $name = $this->name;
        if (Route::is('admin.*')) {
            return "<a href='".route('admin.location_groups.edit', $this->id)."'>".$name."</a>";
        }
        return $name;
    }
}
