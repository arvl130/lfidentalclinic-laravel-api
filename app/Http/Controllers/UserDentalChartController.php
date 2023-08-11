<?php

namespace App\Http\Controllers;

use App\Models\DentalChart;
use App\Models\MedicalChart;
use App\Models\User;
use Illuminate\Http\Request;

class UserDentalChartController extends Controller
{
    public function showFilledIn(string $patientUid)
    {
        $user = User::find($patientUid);

        if (!$user) {
            return response([
                "message" => "No such user"
            ], 404);
        }

        return [
            "message" => "Retrieved filled in status of medical chart",
            "payload" => $user->filled_in_medical_chart
        ];
    }

    public function updateFilledIn(string $patientUid)
    {
        $user = User::find($patientUid);

        if (!$user) {
            return response([
                "message" => "No such user"
            ], 404);
        }

        $user->filled_in_medical_chart = true;
        $user->save();

        return [
            "message" => "Medical chart filled in set",
        ];
    }

    public function showMedicalChart(string $patientUid)
    {
        $medicalChart = MedicalChart::where("patient_uid", $patientUid)->first();

        if (!$medicalChart) {
            return [
                "message" => "Retrieved medical chart",
                "payload" => [
                    "personalInformation" => [
                        "fullName" => "",
                        "gender" => "",
                        "birthDate" => "",
                        "maritalStatus" => "",
                        "mobileNo" => "",
                        "telephoneNo" => "",
                    ],
                    "medicalHistory" => [
                        "heartAilmentDisease" => "",
                        "hospitalAdmission" => "",
                        "selfMedication" => "",
                        "allergies" => "",
                        "operation" => "",
                        "tumors" => "",
                        "diabetes" => false,
                        "sinusitis" => false,
                        "bleedingGums" => false,
                        "hypertension" => false,
                        "stomachDisease" => false,
                        "bloodDisease" => false,
                        "headache" => false,
                        "liverDisease" => false,
                        "cold" => false,
                        "kidneyDisease" => false,
                        "pregnant" => "",
                        "familyHistory" => "",
                    ],
                    "dentalHistory" => [
                        "bleedingInMouth" => false,
                        "gumsChangeColor" => false,
                        "sensitiveTeeth" => false,
                        "badBreath" => false,
                        "palate" => false,
                        "teethChangeColor" => false,
                        "lumpsInMouth" => false,
                        "clickingSoundInMouth" => false,
                        "pastDentalCare" => "",
                    ],
                ]
            ];
        }

        return [
            "message" => "Retrieved medical chart",
            "payload" => [
                "personalInformation" => [
                    "fullName" => $medicalChart->full_name ?? "",
                    "gender" => $medicalChart->gender ?? "",
                    "birthDate" => $medicalChart->birth_date ?? "",
                    "maritalStatus" => $medicalChart->marital_status ?? "",
                    "mobileNo" => $medicalChart->mobile_no ?? "",
                    "telephoneNo" => $medicalChart->telephone_no ?? "",
                ],
                "medicalHistory" => [
                    "heartAilmentDisease" => $medicalChart->heart_ailment_disease ?? "",
                    "hospitalAdmission" => $medicalChart->hospital_admission ?? "",
                    "selfMedication" => $medicalChart->self_medication ?? "",
                    "allergies" => $medicalChart->allergies ?? "",
                    "operation" => $medicalChart->operation ?? "",
                    "tumors" => $medicalChart->tumors ?? "",
                    "diabetes" => $medicalChart->diabetes,
                    "sinusitis" => $medicalChart->sinusitis,
                    "bleedingGums" => $medicalChart->bleeding_gums,
                    "hypertension" => $medicalChart->hypertension,
                    "stomachDisease" => $medicalChart->stomach_disease,
                    "bloodDisease" => $medicalChart->blood_disease,
                    "headache" => $medicalChart->headache,
                    "liverDisease" => $medicalChart->liver_disease,
                    "cold" => $medicalChart->cold,
                    "kidneyDisease" => $medicalChart->kidney_disease,
                    "pregnant" => $medicalChart->pregnant ?? "",
                    "familyHistory" => $medicalChart->family_history ?? "",
                ],
                "dentalHistory" => [
                    "bleedingInMouth" => $medicalChart->bleeding_in_mouth,
                    "gumsChangeColor" => $medicalChart->gums_change_color,
                    "sensitiveTeeth" => $medicalChart->sensitive_teeth,
                    "badBreath" => $medicalChart->bad_breath,
                    "palate" => $medicalChart->palate,
                    "teethChangeColor" => $medicalChart->teeth_change_color,
                    "lumpsInMouth" => $medicalChart->lumps_in_mouth,
                    "clickingSoundInMouth" => $medicalChart->clicking_sound_in_mouth,
                    "pastDentalCare" => $medicalChart->past_dental_care ?? "",
                ],
            ],
        ];
    }

    public function updateMedicalChart(Request $request, string $patientUid)
    {
        $fields = $request->validate([
            'personalInformation.fullName' => "nullable|string",
            'personalInformation.gender' => "nullable|string",
            'personalInformation.birthDate' => "nullable|string",
            'personalInformation.maritalStatus' => "nullable|string",
            'personalInformation.mobileNo' => "nullable|string",
            'personalInformation.telephoneNo' => "nullable|string",
            'dentalHistory.bleedingInMouth' => "required|boolean",
            'dentalHistory.gumsChangeColor' => "required|boolean",
            'dentalHistory.sensitiveTeeth' => "required|boolean",
            'dentalHistory.badBreath' => "required|boolean",
            'dentalHistory.palate' => "required|boolean",
            'dentalHistory.teethChangeColor' => "required|boolean",
            'dentalHistory.lumpsInMouth' => "required|boolean",
            'dentalHistory.clickingSoundInMouth' => "required|boolean",
            'dentalHistory.pastDentalCare' => "nullable|string",
            'medicalHistory.heartAilmentDisease' => "nullable|string",
            'medicalHistory.hospitalAdmission' => "nullable|string",
            'medicalHistory.selfMedication' => "nullable|string",
            'medicalHistory.allergies' => "nullable|string",
            'medicalHistory.operation' => "nullable|string",
            'medicalHistory.tumors' => "nullable|string",
            'medicalHistory.diabetes' => "required|boolean",
            'medicalHistory.sinusitis' => "required|boolean",
            'medicalHistory.bleedingGums' => "required|boolean",
            'medicalHistory.hypertension' => "required|boolean",
            'medicalHistory.stomachDisease' => "required|boolean",
            'medicalHistory.bloodDisease' => "required|boolean",
            'medicalHistory.headache' => "required|boolean",
            'medicalHistory.liverDisease' => "required|boolean",
            'medicalHistory.cold' => "required|boolean",
            'medicalHistory.kidneyDisease' => "required|boolean",
            'medicalHistory.pregnant' => "nullable|string",
            'medicalHistory.familyHistory' => "nullable|string",
        ]);

        $medicalChart = MedicalChart::updateOrCreate([
            "patient_uid" => $patientUid
        ], [
            "patient_uid" => $patientUid,
            // Personal information
            "birth_date" => $fields["personalInformation"]["birthDate"],
            "full_name" => $fields["personalInformation"]["fullName"],
            "gender" => $fields["personalInformation"]["gender"],
            "marital_status" => $fields["personalInformation"]["maritalStatus"],
            "mobile_no" => $fields["personalInformation"]["mobileNo"],
            "telephone_no" => $fields["personalInformation"]["telephoneNo"],
            // Dental history
            "bad_breath" => $fields["dentalHistory"]["badBreath"],
            "bleeding_in_mouth" => $fields["dentalHistory"]["bleedingInMouth"],
            "clicking_sound_in_mouth" => $fields["dentalHistory"]["clickingSoundInMouth"],
            "gums_change_color" => $fields["dentalHistory"]["gumsChangeColor"],
            "lumps_in_mouth" => $fields["dentalHistory"]["lumpsInMouth"],
            "palate" => $fields["dentalHistory"]["palate"],
            "past_dental_care" => $fields["dentalHistory"]["pastDentalCare"],
            "sensitive_teeth" => $fields["dentalHistory"]["sensitiveTeeth"],
            "teeth_change_color" => $fields["dentalHistory"]["teethChangeColor"],
            // Medical history
            "allergies" => $fields["medicalHistory"]["allergies"],
            "bleeding_gums" => $fields["medicalHistory"]["bleedingGums"],
            "blood_disease" => $fields["medicalHistory"]["bloodDisease"],
            "cold" => $fields["medicalHistory"]["cold"],
            "diabetes" => $fields["medicalHistory"]["diabetes"],
            "family_history" => $fields["medicalHistory"]["familyHistory"],
            "headache" => $fields["medicalHistory"]["headache"],
            "heart_ailment_disease" => $fields["medicalHistory"]["heartAilmentDisease"],
            "hospital_admission" => $fields["medicalHistory"]["hospitalAdmission"],
            "hypertension" => $fields["medicalHistory"]["hypertension"],
            "kidney_disease" => $fields["medicalHistory"]["kidneyDisease"],
            "liver_disease" => $fields["medicalHistory"]["liverDisease"],
            "operation" => $fields["medicalHistory"]["operation"],
            "pregnant" => $fields["medicalHistory"]["pregnant"],
            "self_medication" => $fields["medicalHistory"]["selfMedication"],
            "sinusitis" => $fields["medicalHistory"]["sinusitis"],
            "stomach_disease" => $fields["medicalHistory"]["stomachDisease"],
            "tumors" => $fields["medicalHistory"]["tumors"],
        ]);

        return [
            "message" => "Updated medical chart",
            "payload" => [
                "personalInformation" => [
                    "fullName" => $medicalChart->full_name ?? "",
                    "gender" => $medicalChart->gender ?? "",
                    "birthDate" => $medicalChart->birth_date ?? "",
                    "maritalStatus" => $medicalChart->marital_status ?? "",
                    "mobileNo" => $medicalChart->mobile_no ?? "",
                    "telephoneNo" => $medicalChart->telephone_no ?? "",
                ],
                "medicalHistory" => [
                    "heartAilmentDisease" => $medicalChart->heart_ailment_disease ?? "",
                    "hospitalAdmission" => $medicalChart->hospital_admission ?? "",
                    "selfMedication" => $medicalChart->self_medication ?? "",
                    "allergies" => $medicalChart->allergies ?? "",
                    "operation" => $medicalChart->operation ?? "",
                    "tumors" => $medicalChart->tumors ?? "",
                    "diabetes" => $medicalChart->diabetes,
                    "sinusitis" => $medicalChart->sinusitis,
                    "bleedingGums" => $medicalChart->bleeding_gums,
                    "hypertension" => $medicalChart->hypertension,
                    "stomachDisease" => $medicalChart->stomach_disease,
                    "bloodDisease" => $medicalChart->blood_disease,
                    "headache" => $medicalChart->headache,
                    "liverDisease" => $medicalChart->liver_disease,
                    "cold" => $medicalChart->cold,
                    "kidneyDisease" => $medicalChart->kidney_disease,
                    "pregnant" => $medicalChart->pregnant ?? "",
                    "familyHistory" => $medicalChart->family_history ?? "",
                ],
                "dentalHistory" => [
                    "bleedingInMouth" => $medicalChart->bleeding_in_mouth,
                    "gumsChangeColor" => $medicalChart->gums_change_color,
                    "sensitiveTeeth" => $medicalChart->sensitive_teeth,
                    "badBreath" => $medicalChart->bad_breath,
                    "palate" => $medicalChart->palate,
                    "teethChangeColor" => $medicalChart->teeth_change_color,
                    "lumpsInMouth" => $medicalChart->lumps_in_mouth,
                    "clickingSoundInMouth" => $medicalChart->clicking_sound_in_mouth,
                    "pastDentalCare" => $medicalChart->past_dental_care ?? "",
                ],
            ],
        ];
    }

    public function showDentalChart(string $patientUid)
    {
        $dentalChart = DentalChart::where("patient_uid", $patientUid)->first();

        if (!$dentalChart) {
            return [
                "message" => "Retrieved dental chart",
                "payload" => ""
            ];
        }

        return [
            "message" => "Retrieved dental chart",
            "payload" => $dentalChart->dental_chart_data_url ?? "",
        ];
    }

    public function updateDentalChart(Request $request, string $patientUid)
    {
        $fields = $request->validate([
            "dataUrl" => "nullable|string"
        ]);

        $dentalChart = DentalChart::updateOrCreate([
            "patient_uid" => $patientUid
        ], [
            "patient_uid" => $patientUid,
            "dental_chart_data_url" => $fields["dataUrl"]
        ]);

        return [
            "message" => "Updated dental chart",
            "payload" => [
                "dataUrl" => $dentalChart->dental_chart_data_url ?? "",
            ]
        ];
    }

    public function showDeciduousChart(string $patientUid)
    {
        $dentalChart = DentalChart::where("patient_uid", $patientUid)->first();

        if (!$dentalChart) {
            return [
                "message" => "Retrieved deciduous chart",
                "payload" => ""
            ];
        }

        return [
            "message" => "Retrieved deciduous chart",
            "payload" => $dentalChart->deciduous_chart_data_url ?? "",
        ];
    }

    public function updateDeciduousChart(Request $request, string $patientUid)
    {
        $fields = $request->validate([
            "dataUrl" => "nullable|string"
        ]);

        $dentalChart = DentalChart::updateOrCreate([
            "patient_uid" => $patientUid
        ], [
            "patient_uid" => $patientUid,
            "deciduous_chart_data_url" => $fields["dataUrl"]
        ]);


        return [
            "message" => "Updated deciduous chart",
            "payload" => [
                "dataUrl" => $dentalChart->deciduous_chart_data_url ?? "",
            ]
        ];
    }
}
