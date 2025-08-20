<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
    protected $table;

    public function authorize(): bool
    {
        return true;
    }

    abstract public function rules(): array;

    public function attributes(): array
    {
        $attributes = [];
        $rules = $this->rules();

        foreach ($rules as $field => $rule) {
            $attributes[$field] = __("label.columns.{$this->table}.{$field}");
        }

        return $attributes;
    }
}
