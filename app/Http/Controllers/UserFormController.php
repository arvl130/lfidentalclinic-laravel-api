<?php

namespace App\Http\Controllers;

use App\Models\UserAssessmentForm;
use App\Models\UserConsentForm;
use Illuminate\Http\Request;
use stdClass;

class UserFormController extends Controller
{
    public function showConsentForm(string $patientUid)
    {
        $consentForm = UserConsentForm::where("patient_uid", $patientUid)->first();

        if (!$consentForm) {
            return [
                "message" => "Retrieved consent form",
                "payload" => new stdClass()
            ];
        }

        return [
            "message" => "Retrieved consent form",
            "payload" => [
                "checked" => [
                    "daughter" => $consentForm->checked_daughter,
                    "myself" => $consentForm->checked_myself,
                    "relative" => $consentForm->checked_relative,
                    "son" => $consentForm->checked_son,
                ],
                "dateSigned" => $consentForm->date_signed,
                "dentistName" => $consentForm->dentist_name,
                "patientName" => $consentForm->patient_name,
            ]
        ];
    }

    public function updateConsentForm(Request $request, string $patientUid)
    {
        $fields = $request->validate([
            "dataUrl.checked.daughter" => "required|boolean",
            "dataUrl.checked.myself" => "required|boolean",
            "dataUrl.checked.relative" => "required|boolean",
            "dataUrl.checked.son" => "required|boolean",
            "dataUrl.dateSigned" => "required|string",
            "dataUrl.dentistName" => "required|string",
            "dataUrl.patientName" => "required|string",
        ]);

        $consentForm = UserConsentForm::updateOrCreate([
            "patient_uid" => $patientUid
        ], [
            "patient_uid" => $patientUid,
            "checked_daughter" => $fields["dataUrl"]["checked"]["daughter"],
            "checked_myself" => $fields["dataUrl"]["checked"]["myself"],
            "checked_relative" => $fields["dataUrl"]["checked"]["relative"],
            "checked_son" => $fields["dataUrl"]["checked"]["son"],
            "date_signed" => $fields["dataUrl"]["dateSigned"],
            "dentist_name" => $fields["dataUrl"]["dentistName"],
            "patient_name" => $fields["dataUrl"]["patientName"],
        ]);

        return [
            "message" => "Updated consent form",
            "payload" => [
                "dataUrl" => [
                    "checked" => [
                        "daughter" => $consentForm->checked_daughter,
                        "myself" => $consentForm->checked_myself,
                        "relative" => $consentForm->checked_relative,
                        "son" => $consentForm->checked_son,
                    ],
                    "dateSigned" => $consentForm->date_signed,
                    "dentistName" => $consentForm->dentist_name,
                    "patientName" => $consentForm->patient_name,
                ]
            ]
        ];
    }

    public function showAssessmentForm(string $patientUid)
    {
        $assessmentForm = UserAssessmentForm::where("patient_uid", $patientUid)->first();

        if (!$assessmentForm) {
            return [
                "message" => "Retrieved assessment form",
                "payload" => new stdClass()
            ];
        }

        return [
            "message" => "Retrieved assessment form",
            "payload" => [
                "diagnosis" => $assessmentForm->diagnosis,
                "patientsComplaint" => $assessmentForm->patients_complaint,
                "treatmentPlan" => $assessmentForm->treatment_plan,
            ]
        ];
    }

    public function updateAssessmentForm(Request $request, string $patientUid)
    {
        $fields = $request->validate([
            "dataUrl.diagnosis" => "required|string",
            "dataUrl.patientsComplaint" => "required|string",
            "dataUrl.treatmentPlan" => "required|string",
        ]);

        $assessmentForm = UserAssessmentForm::updateOrCreate([
            "patient_uid" => $patientUid
        ], [
            "patient_uid" => $patientUid,
            "diagnosis" => $fields["dataUrl"]["diagnosis"],
            "patients_complaint" => $fields["dataUrl"]["patientsComplaint"],
            "treatment_plan" => $fields["dataUrl"]["treatmentPlan"],
        ]);

        return [
            "message" => "Updated assessment form",
            "payload" => [
                "dataUrl" => [
                    "diagnosis" => $assessmentForm->diagnosis,
                    "patientsComplaint" => $assessmentForm->patients_complaint,
                    "treatmentPlan" => $assessmentForm->treatment_plan,
                ]
            ]
        ];
    }
}
