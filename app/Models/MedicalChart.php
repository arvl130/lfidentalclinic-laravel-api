<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalChart extends Model
{
    use HasFactory;

    protected $fillable = [
        "patient_uid",
        "birth_date",
        "full_name",
        "gender",
        "marital_status",
        "mobile_no",
        "telephone_no",
        "bad_breath",
        "bleeding_in_mouth",
        "clicking_sound_in_mouth",
        "gums_change_color",
        "lumps_in_mouth",
        "palate",
        "past_dental_care",
        "sensitive_teeth",
        "teeth_change_color",
        "allergies",
        "bleeding_gums",
        "blood_disease",
        "cold",
        "diabetes",
        "family_history",
        "headache",
        "heart_ailment_disease",
        "hospital_admission",
        "hypertension",
        "kidney_disease",
        "liver_disease",
        "operation",
        "pregnant",
        "self_medication",
        "sinusitis",
        "stomach_disease",
        "tumors",
    ];

    protected $casts = [
        // Dental history
        "bad_breath" => "boolean",
        "bleeding_in_mouth" => "boolean",
        "clicking_sound_in_mouth" => "boolean",
        "gums_change_color" => "boolean",
        "lumps_in_mouth" => "boolean",
        "palate" => "boolean",
        "sensitive_teeth" => "boolean",
        "teeth_change_color" => "boolean",
        // Medical history
        "bleeding_gums" => "boolean",
        "blood_disease" => "boolean",
        "cold" => "boolean",
        "diabetes" => "boolean",
        "headache" => "boolean",
        "hypertension" => "boolean",
        "kidney_disease" => "boolean",
        "liver_disease" => "boolean",
        "sinusitis" => "boolean",
        "stomach_disease" => "boolean",
    ];

    public $timestamps = false;
}
