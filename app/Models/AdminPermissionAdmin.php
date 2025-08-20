<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminPermissionAdmin extends Model
{
    use SoftDeletes;

    protected $table = 'admin_permission_admin';

    protected $fillable = [
        'admin_id',
        'admin_permission_id',
    ];
}
