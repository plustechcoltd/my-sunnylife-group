<?php

namespace App\Http\Controllers\Web\Auth;

use App\Broadcasting\AdminWebChannel;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Notifications\Notification;
use App\Services\ActivityLogService;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected ActivityLogService $activityLogService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ActivityLogService $activityLogService)
    {
        $this->middleware('guest');
        $this->activityLogService = $activityLogService;
    }

    public function showRegistrationForm(
    ): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application {
        return view('web.auth.register');
    }

    protected function guard(): \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
    {
        return Auth::guard('user');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'code' => mt_rand(10000000, 99999999),
            'family_name' => $data['name'],
            'first_name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'language' => config('app.locale'),
        ]);
    }

    protected function registered(Request $request, $user): void
    {
        $action = 'register';

        $activity_log = $this->activityLogService->save(
            $user->getTable(),
            $user->id,
            $action,
        );

        $admins = Admin::all();
        foreach ($admins as $admin) {
            $admin->notify(
                new Notification(
                    via: ['mail', AdminWebChannel::class],
                    holder: 'web',
                    category: 'register',
                    action_to_receiver: $action . '_to_admin',
                    data: [
                        'mail' => [
                            'mail_objects' => [
                                $user,
                            ],
                            'cc' => [],
                            'bcc' => [],
                        ],
                        'web' => [
                            'notification_objects' => [
                                auth()->user(),
                                $activity_log,
                            ],
                            'route_name' => null,
                            'route_data' => [],
                        ],
                    ]
                )
            );
        }
    }
}
