<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Route;

class Contract extends Model
{
    use SoftDeletes;
    use Filterable;

    protected $keyType = 'integer';

    protected $fillable = [
        'prefecture_id', 'billing_prefecture_id', 'contract_number', 'contract_status', 'name', 'name_kana',
        'postal_code', 'city', 'address1', 'address2', 'tel', 'fax', 'post_input_yn', 'referral_yn',
        'referral_fulltime_commission', 'referral_parttime_commission', 'referral_spot_commission', 'direct_yn',
        'direct_fulltime_commission', 'direct_parttime_commission', 'direct_spot_commission', 'billing_name',
        'billing_postal_code', 'billing_city', 'billing_address1', 'billing_address2', 'billing_tel', 'billing_fax',
        'billing_department', 'billing_position', 'billing_family_name', 'billing_first_name', 'invoice_mailing_yn',
        'payment_term_type', 'invoice_email_notification_to', 'invoice_email_notification_cc', 'created_at',
        'updated_at', 'deleted_at',
    ];

    protected $casts = [
        'invoice_email_notification_to' => 'array',
        'invoice_email_notification_cc' => 'array',
    ];

    public function prefecture(): BelongsTo
    {
        return $this->belongsTo('App\Models\Prefecture');
    }

    public function billingPrefecture(): BelongsTo
    {
        return $this->belongsTo('App\Models\Prefecture', 'billing_prefecture_id');
    }

    public function contractEmployers(): HasMany
    {
        return $this->hasMany('App\Models\ContractEmployer');
    }

    public function contractFiles(): HasMany
    {
        return $this->hasMany('App\Models\ContractFile');
    }

    public function locations(): HasMany
    {
        return $this->hasMany('App\Models\Location');
    }

    public function spotPosts(): HasMany
    {
        return $this->hasMany('App\Models\SpotPost');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany('App\Models\Invoice');
    }

    public function employers(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Employer');
    }

    public function getContractStatusLabelAttribute()
    {
        $contract_statuses = config('const.contract_statuses');

        return @$contract_statuses[$this->contract_status];
    }

    public function getBillingFullNameAttribute(): string
    {
        return $this->billing_first_name.' '.$this->billing_family_name;
    }

    public function getIcons(): array
    {
        $icon = '<i class="icon-checkmark-circle text-success"></i>';

        return [
            'post_input' => $this->post_input_yn == 'y' ? $icon : '',
            'referral' => $this->referral_yn == 'y' ? $icon : '',
            'direct' => $this->direct_yn == 'y' ? $icon : '',
        ];
    }

    public function displayBillingAddress(): string
    {
        return "<span>{$this->billing_name}</span><br>
            <span class=\"mo-text_span_convert\">$this->billing_department</span><br>
            <span class=\"mo-text_span_convert\">$this->billing_full_name</span>";
    }

    public function displayContractStatus(): string
    {
        $config = config('mo.contract_statuses');
        return '<button type="button" class="btn btn-sm btn-'.$config[$this->contract_status].' rounded-pill cursor-default">
                <span class="contract-status fs-xs contract_status_'.$this->contract_status.'">'.$this->contract_status_label.'</span>
            </button>';
    }

    public function getActivityLogNameAttribute(): string
    {
        if ($this->Trashed()) {
            return __('label.labels.deleted');
        }

        $name = $this->name;
        if (Route::is('admin.*')) {
            return "<a href='".route('admin.contracts.edit', $this->id)."'>".$name."</a>";
        }
        return $name;
    }
}
