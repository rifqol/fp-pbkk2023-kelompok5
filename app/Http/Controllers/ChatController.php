<?php

namespace App\Http\Controllers;

use App\Events\ChatMessageSent;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $users = DB::table('users')
            ->join('chats', function(JoinClause $join) {
                $join->on('users.id', '=', 'chats.sender_id')->orOn('users.id', '=', 'chats.receiver_id');
            })->select('users.*')->distinct()->where('users.id', '!=', $user->id)->get();
        // dd($users);
        return view('chat.index')->with(['users' => $users]);
    }

    public function store(Request $request, $id)
    {
        $user = $request->user();

        if(!User::where('id', $id)->first()) {
            return redirect('chats');
        }

        $request->validate([
            'message' => 'required|max:255',
            'attachment_url' => 'nullable',
        ]);

        $message = Chat::create([
            'message' => $request->message,
            'attachment_url' => $request->attachment_url,
            'sender_id' => (string)$user->id,
            'receiver_id' => $id,
        ]);

        broadcast(new ChatMessageSent($message))->toOthers();

        return response()->json([
            'succesfully sent message',
            'message' => $message,
        ]); 
    }

    public function chat(Request $request, $id)
    {
        $user = $request->user();
        // $messages = Chat::with(['sender', 'receiver'])->where('receiver_id', $id)->where('sender_id', $user->id)
        //     ->orWhere('sender_id', $id)->where('receiver_id', $user->id)
        //     ->orderBy('created_at')
        //     ->get();
        return view('chat.room')->with(['receiver_id' => $id]);
    }

    public function receiveMessage(Request $request)
    {
        
        // return view('chat.message')->with('messages' => $messages);
    }

    public function reloadChat(Request $request, $id)
    {
        $user = $request->user();
        $messages = Chat::with(['sender', 'receiver'])->where('receiver_id', $id)->where('sender_id', $user->id)
            ->orWhere('sender_id', $id)->where('receiver_id', $user->id)
            ->orderBy('created_at')
            ->get();
        return view('chat.message')->with(['messages' => $messages]);
    }
}
