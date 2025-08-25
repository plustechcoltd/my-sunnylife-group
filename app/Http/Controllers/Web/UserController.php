<?php

namespace App\Http\Controllers\Web;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserController extends Controller
{
    /**
     * Display the avatar image for the specified user.
     *
     * @param User $user
     * @return BinaryFileResponse
     * @throws AuthorizationException
     */
    public function showAvatar(User $user): BinaryFileResponse
    {
        // $this->authorize(UserPolicy::VIEW_AVATAR, $user);

        if (!$user->avatar_image_path) {
            return response()->file(public_path(config('const.default_avatar.user')), [
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
            ]);
        }

        return response()->file(FileHelper::path($user->avatar_image_path), [
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
        ]);
    }
}
