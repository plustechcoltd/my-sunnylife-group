<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Station extends Model
{
    use Filterable;

    protected $primaryKey = 'station_cd';

    protected $keyType = 'integer';

    public $incrementing = false;

    protected $fillable = [
        'line_cd', 'prefecture_id', 'station_g_cd', 'station_name', 'station_name_k', 'station_name_r', 'postal_code',
        'address', 'lat', 'lon', 'open_ymd', 'close_ymd', 'e_status', 'e_sort', 'created_at', 'updated_at',
    ];

    public function prefecture(): BelongsTo
    {
        return $this->belongsTo('App\Models\Prefecture');
    }

    public function trainLine(): BelongsTo
    {
        return $this->belongsTo('App\Models\TrainLine', 'line_cd', 'line_cd');
    }

    public function getStationWithLinesAttribute(): array
    {
        $line_cds = Station::where('station_g_cd', $this->station_g_cd)->pluck('line_cd');
        $line_names = TrainLine::whereIn('line_cd', $line_cds)->pluck('line_name')->toArray();

        return [
            'station_name' => $this->station_name,
            'station_g_cd' => $this->station_g_cd,
            'line_name' => implode(',', $line_names),
        ];
    }

    public function getStationWithLineCdAttribute(): array
    {
        $line_cd = Station::where('station_cd', $this->station_cd)->first('line_cd');
        $line_name = TrainLine::where('line_cd', $line_cd->line_cd)->first('line_name');

        return [
            'station_name' => $this->station_name,
            'station_g_cd' => $this->station_g_cd,
            'line_name' => $line_name->line_name,
        ];
    }
}
