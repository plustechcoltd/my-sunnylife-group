<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
     *
     * @var string
     */
    protected $redirectTo;

    protected ActivityLogService $activityLogService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ActivityLogService $activityLogService)
    {
        $this->middleware('guest:user')->except('logout');
        $this->redirectTo = RouteServiceProvider::USER_HOME();
        $this->activityLogService = $activityLogService;
    }

    public function showLoginForm(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('web.auth.login');
    }

    /**
     * @param User $user
     */
    public function authenticated(Request $request, $user): void
    {
        Auth::shouldUse('user');
        $this->activityLogService->save(
            $user->getTable(),
            $user->id,
            'login',
        );
    }

    protected function guard(): Guard|StatefulGuard
    {
        return Auth::guard('user');
    }

    public function logout(Request $request)
    {
        $locale = $request->session()->get('user_locale');

        $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $request->session()->put('user_locale', $locale);

        return $this->loggedOut($request) ?: redirect()->route('web.login');
    }
}
