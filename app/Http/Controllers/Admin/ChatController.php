<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChatMessageFileRequest;
use App\Http\Requests\Admin\ChatMessageRequest;
use App\Models\ChatMember;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Services\ChatService;
use DB;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    protected ChatService $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function index()
    {
        $chatRoomId = $this->chatService->getLatestChatRoomId('admins');
        if (!$chatRoomId) {
            return view('admin.chats.index');
        }

        return redirect()->route('admin.chats.show', ['chat' => $chatRoomId]);
    }

    public function show(ChatRoom $chat): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.chats.show', [
            'room' => $chat,
        ]);
    }

    public function messages(ChatRoom $chat, Request $request): JsonResponse
    {
        $messages = $chat->messages()
            ->with('member', 'chatMessageReads', 'chatFile')
            ->where(function ($query) {
                $query->where('display_type', ChatMessage::DISPLAY_TYPE_ALL)
                    ->orWhere('display_type', ChatMessage::DISPLAY_TYPE_ADMIN);
            })
            ->orderBy(Model::CREATED_AT, 'desc')
            ->skip($request->input('start', 0))
            ->take($request->input('length', 10))
            ->get();

        return response()->json($messages);
    }

    /**
     * @throws Exception
     */
    public function storeMessage(ChatRoom $chat, ChatMessageRequest $request): JsonResponse
    {
        $user = Auth::user();
        $message = $this->chatService->sendMessage($user, $chat, $request->validated()['message']);

        return response()->json($message);
    }

    /**
     * @throws Exception
     */
    public function markAsRead(ChatRoom $chat, Request $request): JsonResponse
    {
        $messageId = $request->message_id;
        $chatMessage = ChatMessage::where('id', $messageId)->first();

        $user = Auth::user();
        $this->chatService->markAsRead($user, $chat, $chatMessage);

        return response()->json();
    }

    public function joinChat(ChatRoom $chat): JsonResponse
    {
        $user = Auth::user();
        DB::beginTransaction();

        try {
            $member = $chat->members()
                ->where('user_table', $user->getTable())
                ->where('user_id', $user->getAuthIdentifier())
                ->first();

            if ($member->status === ChatMember::STATUS_PENDING || $member->status === ChatMember::STATUS_LEFT) {
                $member->update(['status' => ChatMember::STATUS_JOINED]);
            }

            $extraData = [
                'user_full_name' => $user->full_name,
                'action' => config('chat.message_types.status.action.joined'),
            ];
            $this->chatService->injectSystemMessage(
                $chat,
                null,
                ChatMessage::MESSAGE_TYPE_STATUS,
                ChatMessage::DISPLAY_TYPE_ALL,
                $extraData
            );

            DB::commit();

            return response()->json(['status' => ChatMember::STATUS_JOINED]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json(['error' => 'Failed to join chat'], 500);
        }
    }

    public function leaveChat(ChatRoom $chat): JsonResponse
    {
        $user = Auth::user();
        DB::beginTransaction();

        try {
            $member = $chat->members()
                ->where('user_table', $user->getTable())
                ->where('user_id', $user->getAuthIdentifier())
                ->first();

            if ($member->status === ChatMember::STATUS_JOINED) {
                $member->update(['status' => ChatMember::STATUS_LEFT]);
            }

            $extraData = [
                'user_full_name' => $user->full_name,
                'action' => config('chat.message_types.status.action.left'),
            ];
            $this->chatService->injectSystemMessage(
                $chat,
                null,
                ChatMessage::MESSAGE_TYPE_STATUS,
                ChatMessage::DISPLAY_TYPE_ALL,
                $extraData
            );

            DB::commit();

            return response()->json(['status' => ChatMember::STATUS_LEFT]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json(['error' => 'Failed to leave chat'], 500);
        }
    }

    public function uploadFile(ChatRoom $chat, ChatMessageFileRequest $request)
    {
        $user = Auth::user();
        $message = $this->chatService->sendMessageWithFile($user, $chat, $request->validated());

        return response()->json(['message' => 'File uploaded successfully', 'message_id' => $message->id]);
    }

    public function showFile(ChatMessage $message)
    {
        // TODO: verify if user has access to the file
        //        $this->authorize('view', $message);

        $filePath = $message->chatFile->file_path;
        return response()->file(FileHelper::path($filePath), [
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
        ]);
    }

}
