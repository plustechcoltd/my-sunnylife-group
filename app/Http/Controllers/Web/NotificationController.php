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
    /**
     * Get notifications for the authenticated web user.
     *
     * @param Request $request
     * @return JsonResponse
     */
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

    /**
     * Mark all notifications as read for the authenticated web user.
     *
     * @param NotificationService $notificationService
     * @return JsonResponse
     */
    public function markAllAsRead(
        NotificationService $notificationService
    ): JsonResponse {
        $notificationService->markAllAsRead(Auth::user());

        return response()->json();
    }

    /**
     * Mark a specific notification as read for the authenticated web user.
     *
     * @param Notification $notification
     * @param NotificationService $notificationService
     * @return JsonResponse
     */
    public function markAsRead(
        Notification $notification,
        NotificationService $notificationService
    ): JsonResponse {
        $notificationService->markAsRead(Auth::user(), $notification);

        return response()->json();
    }
}
