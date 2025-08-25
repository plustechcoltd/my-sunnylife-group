<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Prefecture extends Model
{
    use Filterable;

    protected $keyType = 'integer';

    protected $fillable = ['area_id', 'name', 'name_kana', 'sortno'];

    public function area(): BelongsTo
    {
        return $this->belongsTo('App\Models\Area');
    }

    public function cities(): HasMany
    {
        return $this->hasMany('App\Models\City');
    }

    public function contracts(): HasMany
    {
        return $this->hasMany('App\Models\Contract', 'prefecture_id');
    }

    public function billingContracts(): HasMany
    {
        return $this->hasMany('App\Models\Contract', 'billing_prefecture_id');
    }

    public function doctors(): HasMany
    {
        return $this->hasMany('App\Models\Doctor');
    }

    public function fulltimeDesiredCriterionPrefectures(): HasMany
    {
        return $this->hasMany('App\Models\FulltimeDesiredCriterionPrefecture');
    }

    public function locations(): HasMany
    {
        return $this->hasMany('App\Models\Location');
    }

    public function operatingSettings(): HasMany
    {
        return $this->hasMany('App\Models\OperatingSetting');
    }

    public function stations(): HasMany
    {
        return $this->hasMany('App\Models\Station');
    }

    public function trainLines()
    {
        $stationIds = $this->stations()->pluck('station_cd');

        return TrainLine::whereHas('stations', function ($query) use ($stationIds) {
            $query->whereIn('station_cd', $stationIds);
        })->get();
    }

    public function workHistories(): HasMany
    {
        return $this->hasMany('App\Models\WorkHistory');
    }

    public function fulltimePosts(): HasManyThrough
    {
        return $this->hasManyThrough('App\Models\FulltimePost', 'App\Models\Location', 'prefecture_id', 'location_id');
    }

    public function parttimePosts(): HasManyThrough
    {
        return $this->hasManyThrough('App\Models\ParttimePost', 'App\Models\Location', 'prefecture_id', 'location_id');
    }

    public function spotPosts(): HasManyThrough
    {
        return $this->hasManyThrough('App\Models\SpotPost', 'App\Models\Location', 'prefecture_id', 'location_id');
    }

    public function fulltimePostsCount(): int
    {
        return $this->fulltimePosts()->count();
    }

    public function parttimePostsCount(): int
    {
        return $this->parttimePosts()->count();
    }

    public function spotPostsCount(): int
    {
        return $this->spotPosts()->count();
    }
}
