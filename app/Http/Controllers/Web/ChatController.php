<?php

namespace App\Http\Controllers\Web;

use App\Helpers\FileHelper;
use App\Helpers\UserHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChatMessageFileRequest;
use App\Http\Requests\Admin\ChatMessageRequest;
use App\Models\ChatMember;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Services\ChatService;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    protected ChatService $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    /**
     * Display the chat index or redirect to the latest chat room for the user.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $chatRoomId = $this->chatService->getLatestChatRoomId('users');
        if (!$chatRoomId) {
            return view('web.chats.index');
        }

        return redirect()->route('web.chats.show', ['chat' => $chatRoomId]);
    }

    /**
     * Show the chat room view for the user.
     *
     * @param ChatRoom $chat
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function show(ChatRoom $chat): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $userType = UserHelper::getUserType($user);
        // Check if the user is a member of the room
        $isMember = $chat->members()
            ->where('user_table', $user->getTable())
            ->where('user_id', $user->id)
            ->exists();
        if (!$isMember || $this->chatService->shouldIgnoreRoom($userType, $chat, $user)) {
            abort(404);
        }

        return view('web.chats.show', [
            'room' => $chat,
        ]);
    }

    /**
     * Get chat messages for a chat room.
     *
     * @param ChatRoom $chat
     * @param Request $request
     * @return JsonResponse
     */
    public function messages(ChatRoom $chat, Request $request): JsonResponse
    {
        $messages = $chat->messages()
            ->with('member', 'chatMessageReads', 'chatFile')
            ->where(function ($query) {
                $query->where('display_type', ChatMessage::DISPLAY_TYPE_ALL)
                    ->orWhere('display_type', ChatMessage::DISPLAY_TYPE_USER);
            })
            ->orderBy(Model::CREATED_AT, 'desc')
            ->skip($request->input('start', 0))
            ->take($request->input('length', 10))
            ->get();

        return response()->json($messages);
    }

    /**
     * Store a new chat message in the chat room.
     *
     * @param ChatRoom $chat
     * @param ChatMessageRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function storeMessage(ChatRoom $chat, ChatMessageRequest $request): JsonResponse
    {
        $user = Auth::user();
        $message = $this->chatService->sendMessage($user, $chat, $request->validated()['message']);

        return response()->json($message);
    }

    /**
     * Mark a chat message as read.
     *
     * @param ChatRoom $chat
     * @param Request $request
     * @return JsonResponse
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

    /**
     * Redirect the user to their support chat room.
     *
     * @return RedirectResponse
     */
    public function support(): RedirectResponse
    {
        $user = Auth::user();

        // Check if the user is already subscribed to the support room.
        $room = ChatMember::query()
            ->where('user_table', ChatMember::TABLE_USER)
            ->where('user_id', $user->id)
            ->first();
        if (!$room || !$user->admins) {
            return back()->with('error', 'No admin linked');
        }

        return redirect()->route('web.chats.show', ['chat' => $room->chat_room_id]);
    }

    /**
     * Upload a file and send it as a chat message.
     *
     * @param ChatRoom $chat
     * @param ChatMessageFileRequest $request
     * @return JsonResponse
     */
    public function uploadFile(ChatRoom $chat, ChatMessageFileRequest $request)
    {
        $user = Auth::user();
        $message = $this->chatService->sendMessageWithFile($user, $chat, $request->validated());

        return response()->json(['message' => 'File uploaded successfully', 'message_id' => $message->id]);
    }

    /**
     * Show the file associated with a chat message.
     *
     * @param ChatMessage $message
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
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
