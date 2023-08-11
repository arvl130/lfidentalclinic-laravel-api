<?php

namespace App\Http\Controllers;

use App\Common\Helpers;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserAppointmentController extends Controller
{
    public function index(string $patientUid)
    {
        $appointments = Appointment::where("patient_uid", $patientUid)->get();

        return [
            "message" => "User appointments retrieved",
            "payload" => $appointments->map(fn ($appointment) => $appointment->toCamelCase())
        ];
    }

    public function store(Request $request, string $patientUid)
    {
        $fields = $request->validate([
            "slotSeconds" => "required|unique:appointments,timeslot",
            "service" => "required"
        ]);

        $monthInUnixSeconds = Helpers::getMonthInUnixSeconds($fields["slotSeconds"]);

        Appointment::create([
            "timeslot" => $fields["slotSeconds"],
            "month" => $monthInUnixSeconds,
            "patient_uid" => $patientUid,
            "service" => $fields["service"],
        ]);
        DB::table('reservations')->insert([
            "month" => $monthInUnixSeconds,
            "timeslot" => $fields["slotSeconds"]
        ]);

        return [
            "message" => "New appointment created",
            "payload" => $fields["slotSeconds"]
        ];
    }

    public function updatePayment(Request $request, string $patientUid, string $slotSeconds)
    {
        $appointment = Appointment::find($slotSeconds);

        if (!$appointment) {
            return response([
                "message" => "No such appointment"
            ], 404);
        }

        if ($appointment->patient_uid !== intval($patientUid)) {
            return response([
                "message" => "No such appointment"
            ], 404);
        }


        $fields = $request->validate([
            "price" => "required|numeric|min:0",
            "amountPaid" => "required|numeric|min:0",
            "status" => "nullable|in:Paid,Unpaid"
        ]);

        $appointment->price = $fields["price"];
        $appointment->amount_paid = $fields["amountPaid"];
        $appointment->status = $fields["status"];
        $appointment->save();

        return [
            "message" => "Appointment payment set",
            "payload" => $appointment->toCamelCase()
        ];
    }

    public function updateSetAttended(string $patientUid, string $slotSeconds)
    {
        $appointment = Appointment::find($slotSeconds);

        if (!$appointment) {
            return response([
                "message" => "No such appointment"
            ], 404);
        }

        $appointment->attended = "Yes";
        $appointment->save();

        return [
            "message" => "Appointment set attended",
            "payload" => $appointment->toCamelCase()
        ];
    }

    public function updateSetNotAttended(string $patientUid, string $slotSeconds)
    {
        $appointment = Appointment::find($slotSeconds);

        if (!$appointment) {
            return response([
                "message" => "No such appointment"
            ], 404);
        }

        $appointment->attended = "No";
        $appointment->save();

        return [
            "message" => "Appointment set not attended",
            "payload" => $appointment->toCamelCase()
        ];
    }

    public function updateSetPendingAttended(string $patientUid, string $slotSeconds)
    {
        $appointment = Appointment::find($slotSeconds);

        if (!$appointment) {
            return response([
                "message" => "No such appointment"
            ], 404);
        }

        $appointment->attended = "Pending";
        $appointment->save();

        return [
            "message" => "Appointment set pending attended",
            "payload" => $appointment->toCamelCase()
        ];
    }

    public function showProcedure(string $patientUid, string $slotSeconds)
    {
        $appointment = Appointment::find($slotSeconds);

        if (!$appointment) {
            return response([
                "message" => "No such appointment"
            ], 404);
        }

        return [
            "message" => "Appointment procedure retrieved",
            "payload" => [
                "uid" => (int) $slotSeconds,
                "procedure" => $appointment->procedure,
                "procedureVisible" => $appointment->toCamelCase()["procedureVisible"],
            ]
        ];
    }

    public function updateProcedure(Request $request, string $patientUid, string $slotSeconds)
    {
        $fields = $request->validate([
            "procedureBody" => "required|string"
        ]);

        $appointment = Appointment::find($slotSeconds);

        if (!$appointment) {
            return response([
                "message" => "No such appointment"
            ], 404);
        }

        $appointment->procedure = $fields["procedureBody"];
        $appointment->save();

        return [
            "message" => "Appointment procedure updated",
            "payload" => $appointment->toCamelCase()
        ];
    }

    public function updateSetProcedureAccessAllowed(string $patientUid, string $slotSeconds)
    {
        $appointment = Appointment::find($slotSeconds);

        if (!$appointment) {
            return response([
                "message" => "No such appointment"
            ], 404);
        }

        $appointment->procedure_visible = "Yes";
        $appointment->save();

        return [
            "message" => "Appointment set procedure access allowed",
            "payload" => $appointment->toCamelCase()
        ];
    }

    public function updateSetProcedureAccessNotAllowed(string $patientUid, string $slotSeconds)
    {
        $appointment = Appointment::find($slotSeconds);

        if (!$appointment) {
            return response([
                "message" => "No such appointment"
            ], 404);
        }

        $appointment->procedure_visible = "No";
        $appointment->save();

        return [
            "message" => "Appointment set procedure access allowed",
            "payload" => $appointment->toCamelCase()
        ];
    }

    public function updateRequestProcedureAccess(string $patientUid, string $slotSeconds)
    {
        $appointment = Appointment::find($slotSeconds);

        if (!$appointment) {
            return response([
                "message" => "No such appointment"
            ], 404);
        }

        $appointment->procedure_visible = "Requesting";
        $appointment->save();

        return [
            "message" => "Appointment set procedure access allowed",
            "payload" => $appointment->toCamelCase()
        ];
    }

    public function updateCancelRequestProcedureAccess(string $patientUid, string $slotSeconds)
    {
        $appointment = Appointment::find($slotSeconds);

        if (!$appointment) {
            return response([
                "message" => "No such appointment"
            ], 404);
        }

        $appointment->procedure_visible = "No";
        $appointment->save();

        return [
            "message" => "Appointment set procedure access allowed",
            "payload" => $appointment->toCamelCase()
        ];
    }

    public function cancel(string $patientUid, string $slotSeconds)
    {
        // TODO: Don't allow deletion if past the grace period.
        $appointment = Appointment::find($slotSeconds);

        if (!$appointment) {
            return response([
                "message" => "No such appointment"
            ], 404);
        }

        $appointment->delete();
        $monthInUnixSeconds = Helpers::getMonthInUnixSeconds($slotSeconds);

        DB::table('reservations')->where([
            "month" => $monthInUnixSeconds,
            "timeslot" => $slotSeconds
        ])->delete();

        // TODO: Notify the patient by email after their appointment is cancelled.

        return [
            "message" => "Cancelled appointment",
            "payload" => $appointment->toCamelCase()
        ];
    }

    public function destroy(string $patientUid, string $slotSeconds)
    {
        // TODO: Don't allow deletion if past the grace period.
        $appointment = Appointment::find((int) $slotSeconds);

        if (!$appointment) {
            return response([
                "message" => "No such appointment"
            ], 404);
        }

        $appointment->delete();
        $monthInUnixSeconds = Helpers::getMonthInUnixSeconds($slotSeconds);

        DB::table('reservations')->where([
            "month" => $monthInUnixSeconds,
            "timeslot" => $slotSeconds
        ])->delete();

        return [
            "message" => "Deleted appointment",
            "payload" => $appointment->toCamelCase()
        ];
    }
}
