<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Models\Admin;
use Auth;

class ProfileRequest extends BaseRequest
{
    protected $table = Admin::TABLE_NAME;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'family_name' => 'required',
            'first_name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'allowed_ips' => ['nullable', $this->validateIPs()],
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['email'] .= ','.Auth::user()->id;
        }

        return $rules;
    }

    private function validateIPs(): \Closure
    {
        return function ($attribute, $value, $fail) {
            $ips = explode(',', $value);
            $ips = array_map('trim', $ips);
            foreach ($ips as $ip) {
                if (!filter_var($ip, FILTER_VALIDATE_IP)) {
                    $fail(trans('label.columns.admins.'.$attribute).'には有効なIPアドレスを入力してください。');
                    break;
                }
            }
        };
    }
}
