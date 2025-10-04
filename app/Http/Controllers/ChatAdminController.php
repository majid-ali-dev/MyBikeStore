<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use App\Events\NewChatMessage;
use Illuminate\Support\Facades\Auth;

class ChatAdminController extends Controller
{
    public function liveChat()
    {
        $adminId = Auth::id();
        
        // Get customers who have chatted with admin
        $customers = User::where('role', 'customer')
            ->where(function($query) use ($adminId) {
                $query->whereHas('sentMessages', function($q) use ($adminId) {
                    $q->where('receiver_id', $adminId);
                })->orWhereHas('receivedMessages', function($q) use ($adminId) {
                    $q->where('sender_id', $adminId);
                });
            })
            ->with(['sentMessages' => function($query) use ($adminId) {
                $query->where('receiver_id', $adminId)->orderBy('created_at', 'desc');
            }])
            ->get()
            ->map(function($customer) use ($adminId) {
                $customer->last_message = $customer->sentMessages
                    ->where('receiver_id', $adminId)
                    ->first();
                return $customer;
            });

        return view('admin.live-chat.index', compact('customers'));
    }

    public function getMessages($customerId)
    {
        $adminId = Auth::id();
        
        $messages = ChatMessage::where(function($query) use ($adminId, $customerId) {
            $query->where('sender_id', $adminId)
                  ->where('receiver_id', $customerId);
        })->orWhere(function($query) use ($adminId, $customerId) {
            $query->where('sender_id', $customerId)
                  ->where('receiver_id', $adminId);
        })->with(['sender', 'receiver'])
          ->orderBy('created_at', 'asc')
          ->get();

        // Mark messages as read
        ChatMessage::where('sender_id', $customerId)
                  ->where('receiver_id', $adminId)
                  ->where('is_read', false)
                  ->update(['is_read' => true]);

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000'
        ]);

        $message = ChatMessage::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'type' => 'text'
        ]);

        $message->load('sender', 'receiver');

        broadcast(new NewChatMessage($message))->toOthers();

        return response()->json($message);
    }

    public function getCustomers()
    {
        $adminId = Auth::id();
        
        $customers = User::where('role', 'customer')
            ->where(function($query) use ($adminId) {
                $query->whereHas('sentMessages', function($q) use ($adminId) {
                    $q->where('receiver_id', $adminId);
                })->orWhereHas('receivedMessages', function($q) use ($adminId) {
                    $q->where('sender_id', $adminId);
                });
            })
            ->withCount(['sentMessages as unread_messages_count' => function($query) use ($adminId) {
                $query->where('receiver_id', $adminId)
                      ->where('is_read', false);
            }])
            ->get()
            ->map(function($customer) use ($adminId) {
                $customer->last_message = $customer->sentMessages()
                    ->where('receiver_id', $adminId)
                    ->orderBy('created_at', 'desc')
                    ->first();
                return $customer;
            });

        return response()->json($customers);
    }
}