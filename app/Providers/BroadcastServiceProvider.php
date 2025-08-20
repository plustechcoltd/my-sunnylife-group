<?php

namespace App\Providers;

use App\Helpers\UserHelper;
use App\Models\ChatMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Broadcast::routes();

        require base_path('routes/channels.php');
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        // view share statuses
        view()->composer('*', function ($view) {
            if (Auth::check()) {
                $statuses = [
                    'joined' => ChatMember::STATUS_JOINED,
                    'pending' => ChatMember::STATUS_PENDING,
                    'left' => ChatMember::STATUS_LEFT,
                ];
                $chatService = app('App\Services\ChatService');
                $members = $chatService->listMembers();
                $userType = UserHelper::getUserType(Auth::user());
                $view->with([
                    'statuses' => $statuses,
                    'members' => $members,
                    'userType' => $userType,
                ]);
            }
        });
    }
}
