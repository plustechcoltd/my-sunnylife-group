<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class DataTableService
{
    public function processDataTable($query, Request $request, $columns): array
    {
        // Get the table name from the query
        $tableName = $query->getModel()->getTable();

        // Handle search
        if ($request->has('search') && !empty($request->input('search')['value'])) {
            $searchValue = $request->input('search')['value'];
            $query->where(function ($query) use ($searchValue, $columns, $tableName) {
                foreach ($columns as $column) {
                    // Check if the column belongs to a related table
                    if (str_contains($column, '.')) {
                        // Split the column name into the relation name and the actual column name
                        [$relation, $relatedColumn] = explode('.', $column);

                        // Add a condition on the related table
                        $query->orWhereHas($relation, function ($query) use ($relatedColumn, $searchValue) {
                            $query->where($relatedColumn, 'like', '%'.$searchValue.'%');
                        });
                    } else {
                        // Skip the column if it's not a real table column
                        if (Schema::hasColumn($tableName, $column)) {
                            $query->orWhere($column, 'like', '%'.$searchValue.'%');
                        }
                    }
                }
            });
        }

        if ($request->has('order')) {
            $order = $request->input('order')[0];
            $orderByColumn = $columns[$order['column']];
            $orderDirection = $order['dir'];

            // Skip the column if it's not a real table column
            if (Schema::hasColumn($tableName, $orderByColumn)) {
                $query->orderBy($orderByColumn, $orderDirection);
            }
        }

        // Get total count before pagination
        $totalFiltered = $query->count();

        // Handle pagination
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $query->skip($start)->take($length);

        // Get filtered count after pagination
        $totalData = $query->count();

        // Prepare response data
        return [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $query->get(),
        ];
    }
}
