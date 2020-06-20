<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class ChatController
 */
class ChatController extends Controller
{

    public function index()
    {
        $chatsPrivate = Chat::where('type_chat', Chat::TYPE_PRIVATE)->get();
        $chatsGroup = Chat::where('type_chat', Chat::TYPE_GROUP)->get();

        $usersInChat[] = \Auth::id();
        $users = User::whereNotIn('id', $usersInChat)->get();

        return view('cabinet.chat.index', compact('chatsGroup', 'chatsPrivate', 'users'));
    }

    public function view(Request $request, $uniqId)
    {
        $chatsPrivate = Chat::where('type_chat', Chat::TYPE_PRIVATE)->get();
        $chatsGroup = Chat::where('type_chat', Chat::TYPE_GROUP)->get();

        $users = [];
        $messages = [];
        $chat = Chat::where('uniq_id', $uniqId)->first();
        if ($chat) {
            $messages = ChatMessage::where('chat_id', $chat->id)->orderBy('created_at')->get();

            $usersInChat = array_column($chat->users->toArray(), 'id');
            $usersInChat[] = \Auth::id();

            $users = User::whereNotIn('id', $usersInChat)->get();
        }

        if ($request->isXmlHttpRequest()) {
            $message = new ChatMessage();
            $message->message = $request->get('message');
            $message->chat_id = $request->get('id');
            $message->user_id = \Auth::id();

            $message->save();
            $message->load('user');

            return view('cabinet.chat.blocks.message', compact('message'));
        }

        return view('cabinet.chat.view', compact('chatsGroup', 'chatsPrivate', 'messages', 'chat', 'users'));
    }

    public function groupAdd(Request $request)
    {
        if ($request->isMethod('post')) {
            $chat = new Chat();
            $chat->name = $request->get('name');
            $chat->type_chat = Chat::TYPE_GROUP;
            $chat->uniq_id = \Str::random(32);

            $chat->save();

            $chat->users()->attach(\Auth::id());


            return redirect()->route('cabinet.chat.view', ['uniq_id' => $chat->uniq_id]);
        }

        return redirect()->route('cabinet.chat.index');
    }

    public function inviteUser(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->get('type_chat') == Chat::TYPE_PRIVATE) {

                $chat = Chat::select('chats.*')
                    ->join('chat_user', 'chat_user.chat_id', '=', 'chats.id')
                    ->leftJoin('chat_user as chat_user_2', 'chat_user.chat_id', '=', 'chat_user_2.chat_id')
                    ->where(['chats.type_chat' => Chat::TYPE_PRIVATE, 'chat_user.user_id' => $request->get('user_id'), 'chat_user_2.user_id' => \Auth::id()])
                    ->groupBy('chats.id')
                    ->first();

                if (!$chat) {
                    $chat = new Chat();
                    $chat->type_chat = Chat::TYPE_PRIVATE;
                    $chat->uniq_id = \Str::random(32);

                    $chat->save();

                    $chat->users()->attach([\Auth::id(), $request->get('user_id')]);
                }
            }

            if ($request->get('type_chat') == Chat::TYPE_GROUP) {
                $chat = Chat::find($request->get('chat_id'));
                $chat->users()->attach($request->get('user_id'));

                $chat->save();
            }

            return redirect()->route('cabinet.chat.view', ['uniq_id' => $chat->uniq_id]);
        }

        return redirect()->route('cabinet.chat.index');
    }

    public function chatLoad(Request $request)
    {
        if ($request->isXmlHttpRequest()) {

            $chat = Chat::find($request->get('chat_id'));

            $query = ChatMessage::where('chat_id', $chat->id);

            if ($request->get('last_id')) {
                $query->where('id', '>', $request->get('last_id'));
            }

            $messages = $query->orderBy('created_at')->with('user')->get();

            return view('cabinet.chat.blocks.messages', compact('messages'));
        }

        return response(['status' => 0]);
    }

    public function delete(Request $request)
    {
        $brand = Brand::findOrFail($request->get('id'));

        if ($brand) {
            $brand->delete();

            return response(['status' => 1, 'type' => 'success', 'message' => "Производитель {$brand->name} удален!"]);
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка при удалении!']);
    }
}
