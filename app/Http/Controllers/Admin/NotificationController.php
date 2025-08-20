<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification as Notification;
use App\Services\AdminNotificationService as NotificationService;
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
            ->where('admin_id', $userId)
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
