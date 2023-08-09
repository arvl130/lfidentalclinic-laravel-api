<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function indexYearMonth(string $year, string $month)
    {
        // TODO: Validate if year and month is numeric.
        $monthInUnixSeconds = DateTime::createFromFormat(
            "Y-m-d h:i",
            "{$year}-{$month}-1 00:00",
            new DateTimeZone('Asia/Manila')
        )->getTimestamp();

        $appointments = Appointment::where("month", $monthInUnixSeconds)->get();

        return [
            "message" => "List of appointments for {$year}-{$month}",
            "payload" => $appointments->map(function ($appointment) {
                $procedureVisible = "requesting";
                if ($appointment->procedure_visible === "Yes") {
                    $procedureVisible = true;
                } else if ($appointment->procedure_visible === "No") {
                    $procedureVisible = false;
                }

                $attended = "pending";
                if ($appointment->attended === "Yes") {
                    $attended = true;
                } else if ($appointment->attended === "No") {
                    $attended = false;
                }

                return [
                    "timeslot" => $appointment->timeslot,
                    "month" => $appointment->month,
                    "patientUid" => $appointment->patient_uid,
                    "attended" => $attended,
                    "price" => floatval($appointment->price),
                    "amountPaid" => floatval($appointment->amount_paid),
                    "service" => $appointment->service,
                    "status" => $appointment->status,
                    "procedure" => $appointment->procedure,
                    "procedureVisible" => $procedureVisible,
                    "createdAt" => $appointment->created_at,
                    "updatedAt" => $appointment->updated_at,
                ];
            })
        ];
    }

    public function indexRequestingProcedureAccess()
    {
        $appointments = Appointment::where("procedure_visible", "Requesting")->get();

        return [
            "message" => "List of appointments requesting procedure access",
            "payload" => $appointments->map(function ($appointment) {
                $procedureVisible = "requesting";
                if ($appointment->procedure_visible === "Yes") {
                    $procedureVisible = true;
                } else if ($appointment->procedure_visible === "No") {
                    $procedureVisible = false;
                }

                $attended = "pending";
                if ($appointment->attended === "Yes") {
                    $attended = true;
                } else if ($appointment->attended === "No") {
                    $attended = false;
                }

                return [
                    "timeslot" => $appointment->timeslot,
                    "month" => $appointment->month,
                    "patientUid" => $appointment->patient_uid,
                    "attended" => $attended,
                    "price" => floatval($appointment->price),
                    "amountPaid" => floatval($appointment->amount_paid),
                    "service" => $appointment->service,
                    "status" => $appointment->status,
                    "procedure" => $appointment->procedure,
                    "procedureVisible" => $procedureVisible,
                    "createdAt" => $appointment->created_at,
                    "updatedAt" => $appointment->updated_at,
                ];
            })
        ];
    }
}
