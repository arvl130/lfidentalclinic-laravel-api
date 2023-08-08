<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    public function show()
    {
        $reminder = Reminder::first();

        if (!$reminder) {
            return [
                "message" => "Reminders retrieved",
                "payload" => ""
            ];
        }

        return [
            "message" => "Reminders retrieved",
            "payload" => $reminder->message
        ];
    }

    public function update(Request $request)
    {
        $fields = $request->validate([
            "message" => "required|max:255"
        ]);

        $reminder = Reminder::updateOrCreate(
            [
                "uid" => "reminders"
            ],
            [
                "message" => $fields["message"]
            ]
        );

        return [
            "message" => "Reminders set",
            "payload" => $reminder->message
        ];
    }
}
