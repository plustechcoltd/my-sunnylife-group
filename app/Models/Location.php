<?php

namespace App\Models;

use App\Traits\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Route;

class Location extends Model
{
    use SoftDeletes;
    use Filterable;

    protected $keyType = 'integer';

    protected $fillable = [
        'contract_id', 'location_group_id', 'prefecture_id', 'city_id', 'code', 'name', 'name_kana',
        'medical_department', 'postal_code', 'address1', 'address2', 'tel', 'url', 'emergency_support_yn',
        'number_of_beds', 'number_of_beds_type', 'number_of_dialysis_beds', 'open_date', 'founder_name', 'manager_name',
        'location', 'lat', 'lon', 'contact_family_name', 'contact_first_name', 'contact_family_name_kana',
        'contact_first_name_kana', 'contact_department', 'contact_position', 'contact_phone', 'contact_email',
        'reference_code', 'created_at', 'updated_at', 'deleted_at', 'employer_title', 'employer_names',
    ];

    protected $casts = [
        'employer_names' => 'array',
    ];

    public function prefecture(): BelongsTo
    {
        return $this->belongsTo('App\Models\Prefecture');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo('App\Models\City');
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo('App\Models\Contract');
    }

    public function locationGroup(): BelongsTo
    {
        return $this->belongsTo('App\Models\LocationGroup');
    }

    public function employerLocations(): HasMany
    {
        return $this->hasMany('App\Models\EmployerLocation');
    }

    public function fulltimePosts(): HasMany
    {
        return $this->hasMany('App\Models\FulltimePost');
    }

    public function locationAccesses(): HasMany
    {
        return $this->hasMany('App\Models\LocationAccess');
    }

    public function locationLocationTypes(): HasMany
    {
        return $this->hasMany('App\Models\LocationLocationType');
    }

    public function parttimePosts(): HasMany
    {
        return $this->hasMany('App\Models\ParttimePost');
    }

    public function employers(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Employer')->withTimestamps();
    }

    public function locationTypeSearch(): HasMany
    {
        return $this->hasMany('App\Models\LocationLocationType')->orderBy('id');
    }

    public function getCountFulltimePostAttribute(): int
    {
        return $this->fulltimePosts()
            ->where('post_publish_status', 1)
            ->where(function ($query) {
                $query->where('publish_end_at', '=', null)
                    ->orWhere(function ($q) {
                        $now = Carbon::now();
                        $q->where('publish_at', '<=', $now)
                            ->where('publish_end_at', '>=', $now);
                    });
            })
            ->count();
    }

    public function getCountParttimePostAttribute(): int
    {
        return $this->parttimePosts()
            ->where('post_publish_status', 1)
            ->where(function ($query) {
                $query->where('publish_end_at', '=', null)
                    ->orWhere(function ($q) {
                        $now = Carbon::now();
                        $q->where('publish_at', '<=', $now)
                            ->where('publish_end_at', '>=', $now);
                    });
            })
            ->count();
    }

    public function getFullAddressAttribute(): string
    {
        return $this->prefecture->name.$this->city->name.$this->address1.$this->address2;
    }

    public function getContactNameAttribute(): string
    {
        return $this->contact_family_name.' '.$this->contact_first_name;
    }

    public function getActivityLogNameAttribute(): string
    {
        if ($this->Trashed()) {
            return __('label.labels.deleted');
        }

        $name = $this->name;
        if (Route::is('admin.*')) {
            return "<a href='".route('admin.locations.edit', $this->id)."'>".$name."</a>";
        }
        return $name;
    }
}
