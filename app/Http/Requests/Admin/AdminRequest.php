<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Models\Admin;

class AdminRequest extends BaseRequest
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
            'allowed_ips' => ['nullable', $this->validateIPs()],
        ];
        if ('admin.admins.store' == $this->route()->action['as']) {
            $rules += [
                'email' => 'required|email|unique:admins,email',
                'admin_permissions' => 'array|required',
                'password' => 'required|confirmed|min:8',
            ];
        } elseif ('admin.admins.update' == $this->route()->action['as']) {
            $rules += [
                'email' => 'required|email|unique:admins,email,'.($this->admin ? $this->admin->id : ''),
            ];
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
