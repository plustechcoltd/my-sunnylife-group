<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Models\User;

class UserRequest extends BaseRequest
{
    protected $table = User::TABLE_NAME;

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
        if ('admin.users.store' == $this->route()->action['as']) {
            $rules += [
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed|min:8',
            ];
        } elseif ('admin.users.update' == $this->route()->action['as']) {
            $rules += [
                'email' => 'required|email|unique:admins,email,'.($this->user ? $this->user->id : ''),
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
                    $fail(trans('label.columns.users.'.$attribute).'には有効なIPアドレスを入力してください。');
                    break;
                }
            }
        };
    }
}
