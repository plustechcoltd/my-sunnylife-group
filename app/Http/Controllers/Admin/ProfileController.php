<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfilePasswordRequest;
use App\Http\Requests\Admin\ProfilePermissionsRequest;
use App\Http\Requests\Admin\ProfileRequest;
use App\Models\Admin;
use App\Models\AdminPermission;
use App\Policies\AdminPolicy;
use App\Services\ActivityLogService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProfileController extends Controller
{
    protected ActivityLogService $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function edit(Request $request): View
    {
        return view('admin.profile.edit', [
            'admin' => $request->user(),
        ]);
    }

    public function editPermissions(Request $request): View
    {
        $permissions = AdminPermission::all();

        return view('admin.profile.edit_permissions', [
            'admin' => $request->user(),
            'permissions' => $permissions,
        ]);
    }

    public function editPassword(Request $request): View
    {
        return view('admin.profile.edit_password', [
            'admin' => $request->user(),
        ]);
    }

    public function update(ProfileRequest $request)
    {
        $admin = Auth::user();
        FileHelper::processAvatarUpload($request, $admin, 'filesystems.paths.admin.avatar');

        $allowedIps = $request->input('allowed_ips');
        if ($allowedIps) {
            $allowedIps = explode(',', $allowedIps);
            $allowedIps = array_map('trim', $allowedIps);
            $request->merge(['allowed_ips' => $allowedIps]);
        }
        $admin->update($request->all());

        $this->activityLogService->save(
            $admin->getTable(),
            (string) $admin->id,
            'update_profile',
        );

        return redirect()->route('admin.profile.edit')->with(
            'success',
            __('flash_message.success.update', ['id' => $admin->id, 'name' => $admin->full_name])
        );
    }

    public function updatePermissions(ProfilePermissionsRequest $request)
    {
        $admin = Auth::user();

        $admin->permissions()->sync($request->admin_permissions);

        $this->activityLogService->save(
            $admin->getTable(),
            (string) $admin->id,
            'update_profile_permissions',
        );

        return redirect()->route('admin.profile.edit_permissions')->with(
            'success',
            __('flash_message.success.update', ['id' => $admin->id, 'name' => $admin->full_name])
        );
    }

    public function updatePassword(ProfilePasswordRequest $request)
    {
        $admin = Auth::user();

        $admin->fill($request->all());
        $admin->save();

        $this->activityLogService->save(
            $admin->getTable(),
            (string) $admin->id,
            'update_profile_password',
        );

        return redirect()->route('admin.profile.edit_password')->with(
            'success',
            __('flash_message.success.update', ['id' => $admin->id, 'name' => $admin->full_name])
        );
    }

    /**
     * @throws AuthorizationException
     */
    public function showAvatar(): BinaryFileResponse
    {
        /** @var Admin $admin */
        $admin = Auth::user();
        $this->authorize(AdminPolicy::VIEW_AVATAR, $admin);

        if (!$admin->avatar_image_path) {
            return response()->file(public_path(config('const.default_avatar.admin')), [
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
            ]);
        }

        return response()->file(FileHelper::path($admin->avatar_image_path), [
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
        ]);
    }
}
