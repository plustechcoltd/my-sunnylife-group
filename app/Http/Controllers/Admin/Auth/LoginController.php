<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use App\Services\ActivityLogService;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     */
    protected string $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
        $this->redirectTo = RouteServiceProvider::ADMIN_HOME();
    }

    public function showLoginForm(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('admin.auth.login');
    }

    /**
     * @param Admin $user
     */
    public function authenticated(Request $request, $user): void
    {
        Auth::shouldUse('admin');
        $activityLogService = resolve(ActivityLogService::class);
        $activityLogService->save(
            $user->getTable(),
            (string)$user->id,
            "login"
        );
    }

    protected function guard(): Guard|StatefulGuard
    {
        return Auth::guard('admin');
    }

    public function logout(Request $request)
    {
        $locale = $request->session()->get('admin_locale');

        $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $request->session()->put('admin_locale', $locale);

        return $this->loggedOut($request) ?: redirect()->route('admin.login');
    }
}
