<?php

namespace App\Http\Controllers;

use App\Common\Helpers;
use App\Models\Appointment;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimeslotController extends Controller
{
    public function store(Request $request)
    {
        $fields = $request->validate([
            "slotSeconds" => "required|unique:appointments,timeslot",
            "patientUid" => "required",
            "service" => "required",
        ]);

        $date = new DateTime(strtotime($fields["slotSeconds"]), new DateTimeZone('Asia/Manila'));
        $year = $date->format("Y");
        $month = $date->format("m");

        // TODO: Validate if year and month is numeric.
        $monthInUnixSeconds = DateTime::createFromFormat(
            "Y-m-d h:i",
            "{$year}-{$month}-1 00:00",
            new DateTimeZone('Asia/Manila')
        )->getTimestamp();

        Appointment::create([
            "timeslot" => $fields["slotSeconds"],
            "month" => $monthInUnixSeconds,
            "patient_uid" => $fields["patientUid"],
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

        // TODO: Send email notification after an appointment is created.
    }

    public function destroy(string $slotSeconds)
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
            "message" => "Deleted appointment",
            "payload" => [
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
            ]
        ];
    }

    public function storeClosed(Request $request)
    {
        $fields = $request->validate([
            "slotSeconds" => "required|unique:appointments,timeslot",
        ]);

        $date = new DateTime(strtotime($fields["slotSeconds"]), new DateTimeZone('Asia/Manila'));
        $year = $date->format("Y");
        $month = $date->format("m");

        // TODO: Validate if year and month is numeric.
        $monthInUnixSeconds = DateTime::createFromFormat(
            "Y-m-d h:i",
            "{$year}-{$month}-1 00:00",
            new DateTimeZone('Asia/Manila')
        )->getTimestamp();

        DB::table('reservations')->insert([
            "month" => $monthInUnixSeconds,
            "timeslot" => $fields["slotSeconds"]
        ]);

        return [
            "message" => "Closed slot added",
            "payload" => $fields["slotSeconds"],
        ];
    }

    public function destroyClosed(string $slotSeconds)
    {
        // TODO: Validate if slot seconds is numeric.
        $date = new DateTime(strtotime($slotSeconds), new DateTimeZone('Asia/Manila'));
        $year = $date->format("Y");
        $month = $date->format("m");

        // TODO: Validate if year and month is numeric.
        $monthInUnixSeconds = DateTime::createFromFormat(
            "Y-m-d h:i",
            "{$year}-{$month}-1 00:00",
            new DateTimeZone('Asia/Manila')
        )->getTimestamp();

        DB::table('reservations')->where([
            "month" => $monthInUnixSeconds,
            "timeslot" => $slotSeconds
        ])->delete();

        return [
            "message" => "Closed slot deleted",
            "payload" => intval($slotSeconds),
        ];
    }

    public function index(string $year, string $month)
    {
        // TODO: Validate if year and month is numeric.
        $monthInUnixSeconds = DateTime::createFromFormat(
            "Y-m-d h:i",
            "{$year}-{$month}-1 00:00",
            new DateTimeZone('Asia/Manila')
        )->getTimestamp();

        $reservations = DB::table("reservations")->where("month", $monthInUnixSeconds)->get();

        return [
            "message" => "List of unavailable timeslots",
            "payload" => $reservations->map(fn ($reservation) => [
                "timeslot" => $reservation->timeslot,
                "status" => $reservation->status
            ])
        ];
    }
}
