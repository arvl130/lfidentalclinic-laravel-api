<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medical_charts', function (Blueprint $table) {
            $table->id();
            $table->uuid("patient_uid");
            $table->foreign("patient_uid")->references("uid")->on("users");
            // Personal information
            $table->string("birth_date")->nullable();
            $table->string("full_name")->nullable();
            $table->enum("gender", ["male", "female", "other"])->nullable();
            $table->enum("marital_status", ["single", "married", "widowed", "separated"])->nullable();
            $table->string("mobile_no")->nullable();
            $table->string("telephone_no")->nullable();
            // Dental history
            $table->boolean("bad_breath");
            $table->boolean("bleeding_in_mouth");
            $table->boolean("clicking_sound_in_mouth");
            $table->boolean("gums_change_color");
            $table->boolean("lumps_in_mouth");
            $table->boolean("palate");
            $table->string("past_dental_care")->nullable();
            $table->boolean("sensitive_teeth");
            $table->boolean("teeth_change_color");
            // Medical history
            $table->string("allergies")->nullable();
            $table->boolean("bleeding_gums");
            $table->boolean("blood_disease");
            $table->boolean("cold");
            $table->boolean("diabetes");
            $table->string("family_history")->nullable();
            $table->boolean("headache");
            $table->string("heart_ailment_disease")->nullable();
            $table->string("hospital_admission")->nullable();
            $table->boolean("hypertension");
            $table->boolean("kidney_disease");
            $table->boolean("liver_disease");
            $table->string("operation")->nullable();
            $table->string("pregnant")->nullable();
            $table->string("self_medication")->nullable();
            $table->boolean("sinusitis");
            $table->boolean("stomach_disease");
            $table->string("tumors")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_charts');
    }
};
