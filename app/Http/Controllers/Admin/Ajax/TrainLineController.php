<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Station;
use App\Models\TrainLine;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TrainLineController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->all();
        $line_cds = Station::getAllByFilters($filters)->pluck('line_cd');
        $line_names = Trainline::whereIn('line_cd', $line_cds)->get();

        return response()->json(['line_names' => $line_names])->setStatusCode(Response::HTTP_OK);
    }
}
