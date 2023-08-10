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
                "users" => $users
            ]
        ];
    }

    public function search(string $nameFilter)
    {
        $users = User::where("is_archived", false)->where("name", "rlike", $nameFilter)->get();

        return [
            "message" => "List of users matched",
            "payload" => [
                "users" => $users
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
                "users" => $users
            ]
        ];
    }

    public function searchArchived(string $nameFilter)
    {
        $users = User::where("is_archived", true)->where("name", "rlike", $nameFilter)->get();

        return [
            "message" => "List of archived users matched",
            "payload" => [
                "users" => $users
            ]
        ];
    }
}
