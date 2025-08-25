<?php

namespace App\Traits;

trait Filterable
{
    public static function getAllByFilters($filters = [], $relations = [])
    {
        $query = self::query();

        foreach ($filters as $field => $value) {
            $query->where($field, $value);
        }

        foreach ($relations as $relation) {
            $query->with($relation);
        }

        return $query->get();
    }
}
