<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DentalChart extends Model
{
    use HasFactory;

    protected $fillable = [
        "patient_uid",
        "dental_chart_data_url",
        "deciduous_chart_data_url",
        "patient_signature_data_url",
        "guardian_signature_data_url",
    ];
    public $timestamps = false;
}
