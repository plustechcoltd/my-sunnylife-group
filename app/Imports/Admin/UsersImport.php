<?php

namespace App\Imports\Admin;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithStartRow;

class UsersImport implements ToModel, WithBatchInserts, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @throws Exception
     */
    public function model(array $row): void
    {
        $this->validateRow($row);

        $user = User::find($row[0]) ?? new User();
        $user->fill([
            'code' => $row[1],
            'family_name' => $row[2],
            'first_name' => $row[3],
            'gender' => $row[4],
            'email' => $row[5],
            'phone' => $row[6],
            'password' => bcrypt('password'),
        ]);
        $user->save();
    }

    /**
     * @throws Exception
     */
    private function validateRow(array $row): void
    {
        $rules = [
            '0' => 'nullable|integer',
            '1' => 'required|integer|unique:users,code,'.$row[0],
            '2' => 'required|string|max:255',
            '3' => 'required|string|max:255',
            '4' => 'nullable',
            '5' => 'required|email|max:255|unique:users,email,'.$row[0],
        ];
        $validator = Validator::make($row, $rules);

        if ($validator->fails()) {
            throw new Exception(json_encode($validator->errors()->all(), JSON_UNESCAPED_UNICODE));
        }
    }

    public function batchSize(): int
    {
        return 100;
    }
}
