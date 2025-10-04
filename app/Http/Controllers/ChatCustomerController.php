<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use App\Events\NewChatMessage;
use Illuminate\Support\Facades\Auth;

class ChatCustomerController extends Controller
{
    public function liveChat()
    {
        return view('customer.live-chat.index');
    }

    public function getMessages()
    {
        $customerId = Auth::id();
        $admin = User::where('role', 'admin')->first();
        
        if (!$admin) {
            return response()->json([]);
        }

        $messages = ChatMessage::where(function($query) use ($admin, $customerId) {
            $query->where('sender_id', $admin->id)
                  ->where('receiver_id', $customerId);
        })->orWhere(function($query) use ($admin, $customerId) {
            $query->where('sender_id', $customerId)
                  ->where('receiver_id', $admin->id);
        })->with(['sender', 'receiver'])
          ->orderBy('created_at', 'asc')
          ->get();

        // Mark admin messages as read
        ChatMessage::where('sender_id', $admin->id)
                  ->where('receiver_id', $customerId)
                  ->where('is_read', false)
                  ->update(['is_read' => true]);

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            return response()->json(['error' => 'Admin not found'], 404);
        }

        $message = ChatMessage::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $admin->id,
            'message' => $request->message,
            'type' => 'text'
        ]);

        $message->load('sender', 'receiver');

        broadcast(new NewChatMessage($message))->toOthers();

        return response()->json($message);
    }

    public function getUnreadCount()
    {
        $admin = User::where('role', 'admin')->first();
        
        if (!$admin) {
            return response()->json(['count' => 0]);
        }

        $unreadCount = ChatMessage::where('sender_id', $admin->id)
                                ->where('receiver_id', Auth::id())
                                ->where('is_read', false)
                                ->count();

        return response()->json(['count' => $unreadCount]);
    }
}