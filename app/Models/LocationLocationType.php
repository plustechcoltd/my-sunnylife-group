<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LocationLocationType extends Model
{
    protected $keyType = 'integer';

    protected $appends = ['location_type_label'];

    protected $fillable = ['location_id', 'location_type', 'created_at', 'updated_at'];

    public function location(): BelongsTo
    {
        return $this->belongsTo('App\Models\Location');
    }

    public function getLocationTypeLabelAttribute(): mixed
    {
        return config('const.location_types')[$this->location_type] ?? '';
    }
}
