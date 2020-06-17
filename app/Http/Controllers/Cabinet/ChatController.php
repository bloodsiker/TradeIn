<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Chat;
use App\Models\ChatMessage;
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

        return view('cabinet.chat.index', compact('chatsGroup', 'chatsPrivate'));
    }

    public function view(Request $request, $uniqId)
    {
        $chatsPrivate = Chat::where('type_chat', Chat::TYPE_PRIVATE)->get();
        $chatsGroup = Chat::where('type_chat', Chat::TYPE_GROUP)->get();

        $messages = [];
        $chat = Chat::where('uniq_id', $uniqId)->first();
        if ($chat) {
            $messages = ChatMessage::where('chat_id', $chat->id)->orderBy('created_at')->get();
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

        return view('cabinet.chat.view', compact('chatsGroup', 'chatsPrivate', 'messages', 'chat'));
    }

    public function groupAdd(Request $request)
    {
        if ($request->isMethod('post')) {
            $chat = new Chat();
            $chat->name = $request->get('name');
            $chat->type_chat = Chat::TYPE_GROUP;
            $chat->uniq_id = \Str::random(32);
            $chat->save();

            return redirect()->route('cabinet.chat.index');
        }

        return redirect()->route('cabinet.chat.index');
    }

    public function edit(Request $request)
    {
        if ($request->isMethod('post') && $request->filled('id')) {

            $brand = Brand::find($request->get('id'));
            $brand->name = $request->get('name');

            $brand->save();

            return redirect()->route('cabinet.brand.list')->with('success', 'Информация обновлена');
        }

        return redirect()->route('cabinet.brand.list')->with('danger', 'Ошибка при обновлении!');
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
