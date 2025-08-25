<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CityController extends Controller
{
    public function index(Request $request)
    {
        if ($request->prefecture_id) {
            $cities = City::where('prefecture_id', $request->prefecture_id)->get();
        } else {
            $cities = City::all();
        }

        return response()->json(['cities' => $cities])->setStatusCode(Response::HTTP_OK);
    }
}
