<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Cut off result to N users.
        $resultLimit = 8;
        $users = User::where("is_archived", false)->take($resultLimit)->get();

        return [
            "message" => "List of users",
            "payload" => [
                "users" => $users->map(fn ($user) => [
                    "uid" => $user->id,
                    "email" => $user->email,
                    "displayName" => $user->name,
                    "accountType" => $user->account_type,
                    "filledInMedicalChart" => $user->filled_in_medical_chart,
                    "isArchived" => $user->is_archived,
                ])
            ]
        ];
    }

    public function search(string $nameFilter)
    {
        $users = User::where("is_archived", false)->where("name", "rlike", $nameFilter)->get();

        return [
            "message" => "List of users matched",
            "payload" => [
                "users" => $users->map(fn ($user) => [
                    "uid" => $user->id,
                    "email" => $user->email,
                    "displayName" => $user->name,
                    "accountType" => $user->account_type,
                    "filledInMedicalChart" => $user->filled_in_medical_chart,
                    "isArchived" => $user->is_archived,
                ])
            ]
        ];
    }

    public function indexArchived()
    {
        // Cut off result to N users.
        $resultLimit = 8;
        $users = User::where("is_archived", true)->take($resultLimit)->get();

        return [
            "message" => "List of archived users",
            "payload" => [
                "users" => $users->map(fn ($user) => [
                    "uid" => $user->id,
                    "email" => $user->email,
                    "displayName" => $user->name,
                    "accountType" => $user->account_type,
                    "filledInMedicalChart" => $user->filled_in_medical_chart,
                    "isArchived" => $user->is_archived,
                ])
            ]
        ];
    }

    public function searchArchived(string $nameFilter)
    {
        $users = User::where("is_archived", true)->where("name", "rlike", $nameFilter)->get();

        return [
            "message" => "List of archived users matched",
            "payload" => [
                "users" => $users->map(fn ($user) => [
                    "uid" => $user->id,
                    "email" => $user->email,
                    "displayName" => $user->name,
                    "accountType" => $user->account_type,
                    "filledInMedicalChart" => $user->filled_in_medical_chart,
                    "isArchived" => $user->is_archived,
                ])
            ]
        ];
    }
}
