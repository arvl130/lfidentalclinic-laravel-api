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
        Schema::create('user_consent_forms', function (Blueprint $table) {
            $table->id();
            $table->uuid("patient_uid");
            $table->foreign("patient_uid")->references("uid")->on("users");
            $table->boolean("checked_daughter");
            $table->boolean("checked_myself");
            $table->boolean("checked_relative");
            $table->boolean("checked_son");
            $table->string("date_signed");
            $table->string("dentist_name");
            $table->string("patient_name");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_consent_forms');
    }
};
