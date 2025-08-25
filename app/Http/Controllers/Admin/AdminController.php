<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminPasswordRequest;
use App\Http\Requests\Admin\AdminPermissionsRequest;
use App\Http\Requests\Admin\AdminRequest;
use App\Models\Admin;
use App\Models\AdminPermission;
use App\Policies\AdminPolicy;
use App\Services\DataTableService;
use App\Services\ActivityLogService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdminController extends Controller
{
    protected DataTableService $dataTableService;
    protected ActivityLogService $activityLogService;

    public function __construct(DataTableService $dataTableService, ActivityLogService $activityLogService)
    {
        $this->dataTableService = $dataTableService;
        $this->activityLogService = $activityLogService;
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                'id', 'code', 'family_name', 'first_name', 'email', 'phone',
            ];
            $data = Admin::select($columns);

            $response = $this->dataTableService->processDataTable($data, $request, $columns);
            // Modify the response to include the edit and destroy URLs for each admin
            $response['data'] = $response['data']->map(function ($admin) {
                $admin->edit_url = route('admin.admins.edit', $admin->id);
                $admin->destroy_url = route('admin.admins.destroy', $admin->id);

                return $admin;
            });

            return response()->json($response);
        }

        return view('admin.admins.index');
    }

    /**
     * Show the form for creating a new admin.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $admin = new Admin();
        $permissions = AdminPermission::all();

        return view('admin.admins.create', [
            'admin' => $admin,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Store a newly created admin in storage.
     *
     * @param AdminRequest $request
     * @return RedirectResponse
     */
    public function store(AdminRequest $request): RedirectResponse
    {
        $admin = new Admin();
        FileHelper::processAvatarUpload($request, $admin, 'filesystems.paths.admin.avatar');

        $allowedIps = $request->input('allowed_ips');
        if ($allowedIps) {
            $allowedIps = explode(',', $allowedIps);
            $allowedIps = array_map('trim', $allowedIps);
            $request->merge(['allowed_ips' => $allowedIps]);
        }
        $admin->fill($request->all());
        $admin->save();

        $admin->permissions()->sync($request->admin_permissions);

        $this->activityLogService->save(
            $admin->getTable(),
            (string) $admin->id,
            __FUNCTION__
        );

        return redirect()->route('admin.admins.index')->with(
            'success',
            __('flash_message.success.create', ['id' => $admin->id, 'name' => $admin->full_name])
        );
    }

    /**
     * Show the form for editing the specified admin.
     *
     * @param Admin $admin
     * @return \Illuminate\View\View|RedirectResponse
     */
    public function edit(Admin $admin)
    {
        $user = Auth::user();
        if ($admin->id == $user->id) {
            return redirect()->route('admin.profile.edit');
        }

        return view('admin.admins.edit', [
            'admin' => $admin,
        ]);
    }

    /**
     * Show the form for editing permissions of the specified admin.
     *
     * @param Admin $admin
     * @return \Illuminate\View\View|RedirectResponse
     */
    public function editPermissions(Admin $admin)
    {
        $user = Auth::user();
        if ($admin->id == $user->id) {
            return redirect()->route('admin.profile.edit_permissions');
        }

        $permissions = AdminPermission::all();

        return view('admin.admins.edit_permissions', [
            'admin' => $admin,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Show the form for editing password of the specified admin.
     *
     * @param Admin $admin
     * @return \Illuminate\View\View|RedirectResponse
     */
    public function editPassword(Admin $admin)
    {
        $user = Auth::user();
        if ($admin->id == $user->id) {
            return redirect()->route('admin.profile.edit_password');
        }

        return view('admin.admins.edit_password', [
            'admin' => $admin,
        ]);
    }

    /**
     * Update the specified admin in storage.
     *
     * @param AdminRequest $request
     * @param Admin $admin
     * @return RedirectResponse
     */
    public function update(AdminRequest $request, Admin $admin)
    {
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
            __FUNCTION__
        );

        return redirect()->back()->with(
            'success',
            __('flash_message.success.update', ['id' => $admin->id, 'name' => $admin->full_name])
        );
    }

    /**
     * Update permissions for the specified admin.
     *
     * @param AdminPermissionsRequest $request
     * @param Admin $admin
     * @return RedirectResponse
     */
    public function updatePermissions(AdminPermissionsRequest $request, Admin $admin)
    {
        $admin->permissions()->sync($request->admin_permissions);

        $this->activityLogService->save(
            $admin->getTable(),
            (string) $admin->id,
            'update_permissions'
        );

        return redirect()->back()->with(
            'success',
            __('flash_message.success.update', ['id' => $admin->id, 'name' => $admin->full_name])
        );
    }

    /**
     * Update password for the specified admin.
     *
     * @param AdminPasswordRequest $request
     * @param Admin $admin
     * @return RedirectResponse
     */
    public function updatePassword(AdminPasswordRequest $request, Admin $admin)
    {
        $admin->update($request->only('password'));

        $this->activityLogService->save(
            $admin->getTable(),
            (string) $admin->id,
            'update_password'
        );

        return redirect()->back()->with(
            'success',
            __('flash_message.success.update', ['id' => $admin->id, 'name' => $admin->full_name])
        );
    }

    /**
     * Remove the specified admin from storage.
     *
     * @param Admin $admin
     * @return RedirectResponse
     */
    public function destroy(Admin $admin): RedirectResponse
    {
        $user = Auth::user();
        if ($user->id == $admin->id) {
            return redirect()->route('admin.admins.index')->with('error', trans('flash_message.error.self_delete'));
        } else {
            $admin->delete();

            $this->activityLogService->save(
                $admin->getTable(),
                (string) $admin->id,
                __FUNCTION__
            );

            return redirect()->back()->with(
                'success',
                __('flash_message.success.delete', ['id' => $admin->id, 'name' => $admin->full_name])
            );
        }
    }

    /**
     * @throws AuthorizationException
     */
    public function showAvatar(Admin $admin): BinaryFileResponse
    {
        // $this->authorize(AdminPolicy::VIEW_AVATAR, $admin);

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
