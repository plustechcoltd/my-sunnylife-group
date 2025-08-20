<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function index(Request $request)
    {
        $path = explode('/', $request->path());
        $path = end($path);
        if (view()->exists('admin.demo.'.$path)) {
            return view('admin.demo.'.$path);
        }

        return view('errors.404');
    }
}
