<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserConsentForm extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        "patient_uid",
        "checked_daughter",
        "checked_myself",
        "checked_relative",
        "checked_son",
        "date_signed",
        "dentist_name",
        "patient_name",
    ];
}
