<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    const TABLE_NAME = 'languages';

    protected $fillable = [
        'code',
        'flag',
        'label',
        'default_yn',
        'sortno',
    ];

    public function getIsDefaultAttribute()
    {
        return $this->default_yn == 'y';
    }
}
