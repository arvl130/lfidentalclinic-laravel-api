<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $primaryKey = "timeslot";
    protected $fillable = ["timeslot", "month", "patient_uid", "service"];
}
