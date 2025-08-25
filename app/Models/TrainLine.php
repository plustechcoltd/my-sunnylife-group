<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainLine extends Model
{
    protected $primaryKey = 'line_cd';

    protected $keyType = 'integer';

    public $incrementing = false;

    protected $fillable = [
        'company_cd', 'line_name', 'line_name_k', 'line_name_h', 'line_color_c', 'line_color_t', 'line_type', 'lat',
        'lon', 'zoom', 'e_status', 'e_sort', 'created_at', 'updated_at',
    ];

    public function stations(): HasMany
    {
        return $this->hasMany('App\Models\Station', 'line_cd', 'line_cd');
    }
}
