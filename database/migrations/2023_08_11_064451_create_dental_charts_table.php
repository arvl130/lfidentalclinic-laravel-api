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
        Schema::create('dental_charts', function (Blueprint $table) {
            $table->id();
            $table->uuid("patient_uid");
            $table->foreign("patient_uid")->references("uid")->on("users");
            $table->text("dental_chart_data_url")->nullable();
            $table->text("deciduous_chart_data_url")->nullable();
            $table->text("patient_signature_data_url")->nullable();
            $table->text("guardian_signature_data_url")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dental_charts');
    }
};
