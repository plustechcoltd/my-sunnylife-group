<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Route;

class City extends Model
{
    protected $keyType = 'integer';

    protected $fillable = [
        'prefecture_id', 'city_group_id', 'name', 'name_kana', 'search_exclusion_yn', 'sortno', 'created_at',
        'updated_at',
    ];

    public function cityGroup(): BelongsTo
    {
        return $this->belongsTo('App\Models\CityGroup');
    }

    public function prefecture(): BelongsTo
    {
        return $this->belongsTo('App\Models\Prefecture');
    }

    public function doctors(): HasMany
    {
        return $this->hasMany('App\Models\Doctor');
    }

    public function locations(): HasMany
    {
        return $this->hasMany('App\Models\Location');
    }

    public function getActivityLogNameAttribute(): string
    {
        $name = $this->name;
        if (Route::is('admin.*')) {
            return "<a href='".route('admin.cities.edit', $this->id)."'>".$name."</a>";
        }
        return $name;
    }
}
