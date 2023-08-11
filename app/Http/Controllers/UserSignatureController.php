<?php

namespace App\Http\Controllers;

use App\Models\DentalChart;
use Illuminate\Http\Request;

class UserSignatureController extends Controller
{
    public function showPatient(string $patientUid)
    {
        $dentalChart = DentalChart::where("patient_uid", $patientUid)->first();

        if (!$dentalChart) {
            return [
                "message" => "Retrieved patient signature",
                "payload" => ""
            ];
        }

        return [
            "message" => "Retrieved patient signature",
            "payload" => $dentalChart->patient_signature_data_url ?? "",
        ];
    }

    public function updatePatient(Request $request, string $patientUid)
    {
        $fields = $request->validate([
            "dataUrl" => "nullable|string"
        ]);

        $dentalChart = DentalChart::updateOrCreate([
            "patient_uid" => $patientUid
        ], [
            "patient_uid" => $patientUid,
            "patient_signature_data_url" => $fields["dataUrl"]
        ]);

        return [
            "message" => "Updated patient signature",
            "payload" => [
                "dataUrl" => $dentalChart->patient_signature_data_url ?? "",
            ]
        ];
    }

    public function showGuardian(string $patientUid)
    {
        $dentalChart = DentalChart::where("patient_uid", $patientUid)->first();

        if (!$dentalChart) {
            return [
                "message" => "Retrieved guardian signature",
                "payload" => ""
            ];
        }

        return [
            "message" => "Retrieved guardian signature",
            "payload" => $dentalChart->guardian_signature_data_url ?? "",
        ];
    }

    public function updateGuardian(Request $request, string $patientUid)
    {
        $fields = $request->validate([
            "dataUrl" => "nullable|string"
        ]);

        $dentalChart = DentalChart::updateOrCreate([
            "patient_uid" => $patientUid
        ], [
            "patient_uid" => $patientUid,
            "guardian_signature_data_url" => $fields["dataUrl"]
        ]);

        return [
            "message" => "Updated guardian signature",
            "payload" => [
                "dataUrl" => $dentalChart->guardian_signature_data_url ?? "",
            ]
        ];
    }
}
