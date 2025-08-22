<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Display the home page for web users.
     *
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function home(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('web.home');
    }
}
