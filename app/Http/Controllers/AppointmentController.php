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
            "Y-m-d",
            "{$year}-{$month}-1",
            new DateTimeZone('Asia/Manila')
        );

        $appointments = Appointment::where("month", $monthInUnixSeconds)->get();

        return [
            "message" => "List of appointments for {$year}-{$month}",
            "payload" => $appointments
        ];
    }

    public function indexRequestingProcedureAccess()
    {
        $appointments = Appointment::where("procedure_visible", "Requesting")->get();

        return [
            "message" => "List of appointments requesting procedure access",
            "payload" => $appointments
        ];
    }
}
