<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\UserNotification as Notification;
use App\Services\WebNotificationService as NotificationService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(
        Request $request
    ): JsonResponse {
        $userId = $request->user()->id;

        $data = Notification::query()
            ->where('user_id', $userId)
            ->skip($request->input('start'))
            ->take($request->input('length'))
            ->orderByDesc(Model::CREATED_AT)
            ->get();

        return response()->json($data);
    }

    public function markAllAsRead(
        NotificationService $notificationService
    ): JsonResponse {
        $notificationService->markAllAsRead(Auth::user());

        return response()->json();
    }

    public function markAsRead(
        Notification $notification,
        NotificationService $notificationService
    ): JsonResponse {
        $notificationService->markAsRead(Auth::user(), $notification);

        return response()->json();
    }
}
