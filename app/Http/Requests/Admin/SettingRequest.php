<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Models\Setting;

class SettingRequest extends BaseRequest
{
    protected $table = Setting::TABLE_NAME;

    protected function prepareForValidation()
    {
        // dd($this->file());
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'site_title' => ['required', 'string', 'max:255'],
            'site_description' => ['required', 'string', 'max:255'],
            'logo_login' => ['nullable', 'image|mimes:jpeg,png,gif', 'max:1024'],
            'logo' => ['nullable', 'image|mimes:jpeg,png,gif', 'max:1024'],
            'light_logo' => ['nullable', 'image|mimes:jpeg,png,gif', 'max:1024'],
            'favicon' => ['nullable', 'image|mimes:jpeg,png,gif', 'max:1024'],
        ];
    }
}
