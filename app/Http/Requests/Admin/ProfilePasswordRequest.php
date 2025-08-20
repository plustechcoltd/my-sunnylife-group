<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Models\Admin;
use Auth;
use Hash;

class ProfilePasswordRequest extends BaseRequest
{
    protected $table = Admin::TABLE_NAME;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $user = Auth::user();

        return [
            'password' => 'required|confirmed|min:8',
            'current_password' => [
                'required', function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        return $fail(__('validation.current_password'));
                    }
                },
            ],
        ];
    }
}
