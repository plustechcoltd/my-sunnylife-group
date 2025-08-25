<?php

namespace App\Http\Controllers\Admin;

use App\Broadcasting\UserWebChannel;
use App\Exports\Admin\UsersExport;
use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserPasswordRequest;
use App\Http\Requests\Admin\UserRequest;
use App\Imports\Admin\UsersImport;
use App\Models\Admin;
use App\Models\ChatMember;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\User;
use App\Notifications\Notification;
use App\Policies\UserPolicy;
use App\Services\ActivityLogService;
use App\Services\ChatService;
use App\Services\DataTableService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserController extends Controller
{
    protected DataTableService $dataTableService;
    protected ActivityLogService $activityLogService;
    protected ChatService $chatService;

    /**
     * UserController constructor.
     *
     * @param DataTableService $dataTableService
     * @param ActivityLogService $activityLogService
     * @param ChatService $chatService
     */
    public function __construct(DataTableService $dataTableService, ActivityLogService $activityLogService, ChatService $chatService)
    {
        $this->dataTableService = $dataTableService;
        $this->activityLogService = $activityLogService;
        $this->chatService = $chatService;
    }

    /**
     * Display a listing of the users.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = ['id', 'family_name', 'first_name', 'email', 'created_at', 'id'];
            $data = User::select($columns);

            $response = $this->dataTableService->processDataTable($data, $request, $columns);
            // Modify the response to include the edit and destroy URLs for each user
            $response['data'] = $response['data']->map(function ($user) {
                $user->edit_url = route('admin.users.edit', $user->id);
                $user->destroy_url = route('admin.users.destroy', $user->id);
                $user->email = '<a href="mailto:' . $user->email . '">' . $user->email . '</a>';

                return $user;
            });

            return response()->json($response);
        }

        return view('admin.users.index');
    }

    /**
     * Show the avatar image for the specified user.
     *
     * @param User $user
     * @return BinaryFileResponse
     * @throws AuthorizationException
     */
    public function showAvatar(User $user): BinaryFileResponse
    {
        $this->authorize(UserPolicy::VIEW_AVATAR, $user);

        if (!$user->avatar_image_path) {
            return response()->file(public_path(config('const.default_avatar.user')), [
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
            ]);
        }

        return response()->file(FileHelper::path($user->avatar_image_path), [
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
        ]);
    }

    /**
     * Show the form for creating a new user.
     *
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user = new User();

        return view('admin.users.create', [
            'user' => $user,
        ]);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request): RedirectResponse
    {
        $user = new User();
        FileHelper::processAvatarUpload($request, $user, 'filesystems.paths.user.avatar');

        $allowedIps = $request->input('allowed_ips');
        if ($allowedIps) {
            $allowedIps = explode(',', $allowedIps);
            $allowedIps = array_map('trim', $allowedIps);
            $request->merge(['allowed_ips' => $allowedIps]);
        }

        $user->fill($request->all());
        $user->code = mt_rand(10000000, 99999999);
        $user->save();

        $this->activityLogService->save(
            $user->getTable(),
            (string)$user->id,
            __FUNCTION__
        );

        return redirect()->route('admin.users.index')->with(
            'success',
            __('flash_message.success.create', ['id' => $user->id, 'name' => $user->full_name])
        );
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param User $user
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function edit(User $user): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the password of the specified user.
     *
     * @param User $user
     * @return View
     */
    public function editPassword(User $user)
    {
        return view('admin.users.edit_password', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the manager of the specified user.
     *
     * @param User $user
     * @return View
     */
    public function editManager(User $user)
    {
        $listAdmin = Admin::all()->pluck('full_name', 'id');
        $selectedUser = $user->admins->pluck('id')->toArray();

        return view('admin.users.edit_manager', [
            'listUser' => $listAdmin,
            'selectedUser' => $selectedUser,
            'user' => $user,
        ]);
    }

    /**
     * Update the manager of the specified user.
     *
     * @param User $user
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateAdminManager(User $user, Request $request)
    {
        $listManager = $request->input('user_id');
        $roomType = ChatRoom::TYPE_SINGULAR;
        if (count($listManager) > 1) {
            $roomType = ChatRoom::TYPE_GROUP;
        }

        $user->admins()->sync($listManager);

        // Create chat room
        $listChatRooms = ChatMember::query()
            ->where('user_table', ChatMember::TABLE_USER)
            ->where('user_id', $user->id)
            ->whereHas('room', function ($query) use ($roomType) {
                $query->where('type', $roomType);
            })
            ->pluck('chat_room_id');

        $exists = false;
        $roomMembers = ChatMember::query()
            ->where('user_table', ChatMember::TABLE_ADMIN)
            ->whereIn('user_id', $listManager)
            ->whereIn('chat_room_id', $listChatRooms);
        if ($roomMembers->exists()) {
            $listMemberByRooms = $roomMembers->get()->groupBy('chat_room_id');
            foreach ($listMemberByRooms as $room => $members) {
                if (count($members) == count($listManager)) {
                    $exists = true;
                    break;
                }
            }
        }

        if (!$exists) {
            $this->chatService->create($user, $roomType);
        }

        return redirect()->back()->with(
            'success',
            __('flash_message.success.update', ['id' => $user->id, 'name' => $user->full_name])
        );
    }

    /**
     * Update the specified user in storage.
     *
     * @param User $user
     * @param ChatService $chatService
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function update(User $user, ChatService $chatService, UserRequest $request): RedirectResponse
    {
        FileHelper::processAvatarUpload($request, $user, 'filesystems.paths.user.avatar');

        $allowedIps = $request->input('allowed_ips');
        if ($allowedIps) {
            $allowedIps = explode(',', $allowedIps);
            $allowedIps = array_map('trim', $allowedIps);
            $request->merge(['allowed_ips' => $allowedIps]);
        }

        $user->fill($request->all());
        $user->save();

        // Find the chat room that the user is a member of
        $chatRooms = ChatRoom::query()
            ->whereHas('members', function ($query) use ($user) {
                $query->where('user_table', $user->getTable())
                    ->where('user_id', $user->id);
            })
            ->get();

        $extraData = [
            'user_full_name' => $user->full_name,
            'action' => config('chat.message_types.user_action.action.user_updated'),
        ];

        foreach ($chatRooms as $chat) {
            $chatService->injectSystemMessage($chat, null, ChatMessage::MESSAGE_TYPE_USER_ACTION, ChatMessage::DISPLAY_TYPE_ADMIN, $extraData);
        }

        $this->activityLogService->save(
            $user->getTable(),
            (string)$user->id,
            __FUNCTION__
        );

        $user->notify(
            new Notification(
                via: [UserWebChannel::class],
                holder: 'admin',
                category: 'users',
                action_to_receiver: __FUNCTION__ . '_to_user',
                data: [
                    'web' => [
                        'notification_objects' => [
                            auth()->user(),
                            $user,
                        ],
                        'route_name' => 'web.users.show_avatar',
                        'route_data' => [
                            'user' => $user->id,
                        ],
                    ],
                ]
            )
        );

        return redirect()->back()->with(
            'success',
            __('flash_message.success.update', ['id' => $user->id, 'name' => $user->full_name])
        );
    }

    /**
     * Update the password of the specified user.
     *
     * @param User $user
     * @param UserPasswordRequest $request
     * @return RedirectResponse
     */
    public function updatePassword(User $user, UserPasswordRequest $request): RedirectResponse
    {
        $user->fill($request->all());
        $user->save();

        $this->activityLogService->save(
            $user->getTable(),
            (string)$user->id,
            "update_password"
        );

        return redirect()->back()->with(
            'success',
            __('flash_message.success.update', ['id' => $user->id, 'name' => $user->full_name])
        );
    }

    /**
     * Remove the specified user from storage.
     *
     * @param User $user
     * @param ChatService $chatService
     * @return RedirectResponse
     */
    public function destroy(User $user, ChatService $chatService): RedirectResponse
    {
        // Find the chat room that the user is a member of
        $chatRooms = ChatRoom::query()
            ->whereHas('members', function ($query) use ($user) {
                $query->where('user_table', $user->getTable())
                    ->where('user_id', $user->id);
            })
            ->get();

        $extraData = [
            'user_full_name' => $user->full_name,
            'action' => config('chat.message_types.user_action.action.user_deleted'),
        ];

        foreach ($chatRooms as $chat) {
            $chatService->injectSystemMessage($chat, null, ChatMessage::MESSAGE_TYPE_USER_ACTION, ChatMessage::DISPLAY_TYPE_ADMIN, $extraData);

            // Leave user out of the chat room
            $chat->members()->where('user_table', $user->getTable())
                ->where('user_id', $user->id)
                ->delete();
        }

        $user->delete();

        $this->activityLogService->save(
            $user->getTable(),
            (string)$user->id,
            __FUNCTION__
        );

        return redirect()->back()->with(
            'success',
            __('flash_message.success.delete', ['id' => $user->id, 'name' => $user->full_name])
        );
    }

    /**
     * Show the form for importing users from a CSV file.
     *
     * @return View
     */
    public function importCsv()
    {
        return view('admin.users.import');
    }

    /**
     * Upload and import users from a CSV file.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function uploadCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);
        $file = $request->file('csv_file');

        try {
            DB::beginTransaction();
            Excel::import(new UsersImport, $file);

            $user = new User;
            $this->activityLogService->save(
                $user->getTable(),
                '0',
                'import'
            );

            DB::commit();

            return redirect()->route('admin.users.index')->with('success', __('flash_message.success.import'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return redirect()->back()->with('error', __('flash_message.error.import_csv'));
        }
    }

    /**
     * Export the users to a CSV file.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportCsv()
    {
        $user = new User;
        $this->activityLogService->save(
            $user->getTable(),
            '0',
            'export'
        );

        return Excel::download(
            new UsersExport,
            trans('label.tables.users') . '.csv',
            \Maatwebsite\Excel\Excel::CSV,
            ['Content-Type' => 'text/csv']
        );
    }
}
