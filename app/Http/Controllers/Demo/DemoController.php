<?php

namespace App\Http\Controllers\Demo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function layout_1(Request $request)
    {
        $path = explode('/', $request->path());
        $path = end($path);
        if (view()->exists('demo.layout_1.'.$path)) {
            return view('demo.layout_1.'.$path);
        }

        return view('demo.layout_1.errors.404');
    }

    public function layout_2(Request $request)
    {
        $path = explode('/', $request->path());
        $path = end($path);
        if (view()->exists('demo.layout_2.'.$path)) {
            return view('demo.layout_2.'.$path);
        }

        return view('demo.layout_2.errors.404');
    }

    public function layout_6(Request $request)
    {
        $path = explode('/', $request->path());
        $path = end($path);
        if (view()->exists('demo.layout_6.'.$path)) {
            return view('demo.layout_6.'.$path);
        }

        return view('demo.layout_6.errors.404');
    }
}
