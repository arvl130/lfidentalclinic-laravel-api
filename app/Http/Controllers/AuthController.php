<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registerPatient(Request $request)
    {
        $fields = $request->validate([
            "fullName" => "required|string",
            "email" => "required|string|unique:users,email|email:rfc",
            "password" => "required|string"
        ]);

        User::create([
            "name" => $fields["fullName"],
            "email" => $fields["email"],
            "password" => bcrypt($fields["password"])
        ]);

        return [
            "message" => "User created."
        ];
    }

    public function registerAdmin(Request $request)
    {
        $fields = $request->validate([
            "email" => "required|string|unique:users,email|email:rfc",
            "password" => "required|string"
        ]);

        User::create([
            "name" => "Admin User",
            "email" => $fields["email"],
            "password" => bcrypt($fields["password"])
        ]);

        return [
            "message" => "User created."
        ];
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            "email" => "required|string|email:rfc",
            "password" => "required|string"
        ]);

        $user = User::where("email", $fields["email"])->first();

        if (!$user || !Hash::check($fields["password"], $user->password)) {
            return response([
                "message" => "Unauthorized",

            ], 401);
        }

        $token = $user->createToken("myapitoken")->plainTextToken;

        return response([
            "message" => "Logged in.",
            "token" => $token
        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            "message" => "Logged out."
        ];
    }

    public function updateUsername(Request $request)
    {
        $fields = $request->validate([
            "fullName" => "required|string",
        ]);

        $user = User::find($request->user()->id);

        if (!$user) {
            return [
                response([
                    "message" => "User record could not be found.",
                ], 500)
            ];
        }

        $user->name = $fields["fullName"];
        $user->save();

        return [
            "message" => "User name updated.",
            "payload" => [
                "uid" => $user->id,
                "email" => $user->email,
                "fullName" => $user->name
            ],
        ];
    }

    public function showProfile(Request $request)
    {
        $user = User::find($request->user()->id);

        if (!$user) {
            return [
                response([
                    "message" => "User record could not be found.",
                ], 500)
            ];
        }

        return [
            "message" => "User profile retrieved.",
            "payload" => [
                "uid" => $user->id,
                "email" => $user->email,
                "fullName" => $user->name
            ],
        ];
    }
}
