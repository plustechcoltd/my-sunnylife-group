<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TrainStationController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->all();

        $stations = Station::getAllByFilters($filters)->pluck('station_name', 'station_g_cd');

        return response()->json(['stations' => $stations])->setStatusCode(Response::HTTP_OK);
    }
}
