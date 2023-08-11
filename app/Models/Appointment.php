<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $primaryKey = "timeslot";
    protected $fillable = ["timeslot", "month", "patient_uid", "service"];

    public function toCamelCase()
    {
        $procedureVisible = "requesting";
        if ($this->procedure_visible === "Yes") {
            $procedureVisible = true;
        } else if ($this->procedure_visible === "No") {
            $procedureVisible = false;
        }

        $attended = "pending";
        if ($this->attended === "Yes") {
            $attended = true;
        } else if ($this->attended === "No") {
            $attended = false;
        }

        return [
            "timeslot" => $this->timeslot,
            "month" => $this->month,
            "patientUid" => $this->patient_uid,
            "attended" => $attended,
            "price" => floatval($this->price),
            "amountPaid" => floatval($this->amount_paid),
            "service" => $this->service,
            "status" => $this->status,
            "procedure" => $this->procedure,
            "procedureVisible" => $procedureVisible,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
        ];
    }
}
