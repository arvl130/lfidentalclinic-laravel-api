<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAssessmentForm extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        "patient_uid",
        "diagnosis",
        "patients_complaint",
        "treatment_plan",
    ];
}
