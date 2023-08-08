<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::all();

        return [
            "message" => "List of all messages",
            "payload" => $messages->map(fn ($message) => [
                "uid" => $message->uid,
                "senderName" => $message->sender_name,
                "email" => $message->email,
                "body" => $message->body,
                "isArchived" => $message->is_archived,
                "updatedAt" => $message->updated_at,
                "createdAt" => $message->created_at,
            ])
        ];
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            "senderName" => "required|max:255",
            "email" => "required|max:255|email:rfc",
            "body" => "required|max:5000"
        ]);

        $message = Message::create([
            "sender_name" => $fields['senderName'],
            "email" => $fields['email'],
            "body" => $fields['body']
        ]);

        return [
            "message" => "Message created",
            "payload" => [
                "uid" => $message->uid,
                "senderName" => $message->sender_name,
                "email" => $message->email,
                "body" => $message->body,
                "isArchived" => $message->is_archived ?? false,
                "updatedAt" => $message->updated_at,
                "createdAt" => $message->created_at,
            ]
        ];
    }

    public function update(string $uid)
    {
        $message = Message::find($uid);

        if (!$message) {
            return response([
                "message" => "No such message"
            ], 404);
        }


        $message->is_archived = !$message->is_archived;
        $message->save();

        return [
            "message" => "Message is now " . ($message->is_archived ? 'archived' : 'unarchived'),
            "payload" => [
                "uid" => $message->uid,
                "senderName" => $message->sender_name,
                "email" => $message->email,
                "body" => $message->body,
                "isArchived" => $message->is_archived,
                "updatedAt" => $message->updated_at,
                "createdAt" => $message->created_at,
            ]
        ];
    }

    public function destroy(string $uid)
    {
        $message = Message::find($uid);

        if (!$message) {
            return response([
                "message" => "No such message"
            ], 404);
        }

        $message->delete();

        return [
            "message" => "Message deleted",
            "payload" => $message
        ];
    }
}
