<?php

namespace App\Exports\Admin;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    use Exportable;

    public function collection()
    {
        return User::all()->makeHidden([
            'full_name', 'avatar_image_path', 'last_login_at', 'allowed_ips', 'remember_token', 'email_verified_at',
            'password', 'created_at', 'updated_at', 'deleted_at',
        ]);
    }

    public function headings(): array
    {
        return [
            __('label.columns.common.id'),
            __('label.columns.users.code'),
            __('label.columns.users.family_name'),
            __('label.columns.users.first_name'),
            __('label.columns.users.gender'),
            __('label.columns.users.email'),
            __('label.columns.users.phone'),
            __('label.columns.users.language'),
        ];
    }
}
