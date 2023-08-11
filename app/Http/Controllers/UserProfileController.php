<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function show(string $patientUid)
    {
        $user = User::find($patientUid);

        if (!$user) {
            return response([
                "message" => "No such user"
            ], 404);
        }

        return [
            "message" => "User profile retrieved",
            "payload" => [
                "uid" => $user->uid,
                "email" => $user->email,
                "displayName" => $user->name,
                "accountType" => $user->account_type,
                "filledInMedicalChart" => $user->filled_in_medical_chart,
                "isArchived" => $user->is_archived,
            ],
        ];
    }

    public function archive(string $patientUid)
    {
        $user = User::find($patientUid);

        if (!$user) {
            return response([
                "message" => "No such user"
            ], 404);
        }

        $user->is_archived = true;
        $user->save();

        return [
            "message" => "Patient is now archived.",
            "payload" => [
                "uid" => $user->uid,
                "email" => $user->email,
                "displayName" => $user->name,
                "accountType" => $user->account_type,
                "filledInMedicalChart" => $user->filled_in_medical_chart,
                "isArchived" => $user->is_archived,
            ],
        ];
    }

    public function unarchive(string $patientUid)
    {
        $user = User::find($patientUid);

        if (!$user) {
            return response([
                "message" => "No such user"
            ], 404);
        }

        $user->is_archived = false;
        $user->save();

        return [
            "message" => "Patient is now unarchived.",
            "payload" => [
                "uid" => $user->uid,
                "email" => $user->email,
                "displayName" => $user->name,
                "accountType" => $user->account_type,
                "filledInMedicalChart" => $user->filled_in_medical_chart,
                "isArchived" => $user->is_archived,
            ],
        ];
    }
}
