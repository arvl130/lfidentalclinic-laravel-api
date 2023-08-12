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
        Schema::create('user_assessment_forms', function (Blueprint $table) {
            $table->id();
            $table->uuid("patient_uid");
            $table->foreign("patient_uid")->references("uid")->on("users");
            $table->string("diagnosis");
            $table->string("patients_complaint");
            $table->string("treatment_plan");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_assessment_forms');
    }
};
