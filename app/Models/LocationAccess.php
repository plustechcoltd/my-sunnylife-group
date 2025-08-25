<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LocationAccess extends Model
{
    protected $keyType = 'integer';

    protected $fillable = [
        'location_id', 'station_g_cd', 'transportation_type', 'total_time', 'access_text', 'sortno', 'created_at',
        'updated_at',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo('App\Models\Location');
    }

    public function station(): BelongsTo
    {
        return $this->belongsTo('App\Models\Station', 'station_g_cd', 'station_g_cd');
    }

    public function stations(): HasMany
    {
        return $this->HasMany('App\Models\Station', 'station_g_cd', 'station_g_cd');
    }
}
