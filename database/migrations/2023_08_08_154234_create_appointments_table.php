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
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigInteger("timeslot")->primary();
            $table->bigInteger("month");
            $table->uuid('patient_uid');
            $table->foreign("patient_uid")->references("uid")->on("users");
            $table->enum("attended", ["Yes", "No", "Pending"])->default("Pending");
            $table->decimal("price", 10, 2)->default(0);
            $table->decimal("amount_paid", 10, 2)->default(0);
            $table->string("service");
            $table->enum("status", ["Paid", "Unpaid"])->nullable();
            $table->string("procedure", 5000)->default("");
            $table->enum("procedure_visible", ["Yes", "No", "Requesting"])->default("No");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
