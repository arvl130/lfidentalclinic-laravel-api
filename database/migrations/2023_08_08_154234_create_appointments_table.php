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
            $table->bigInteger("timeslot");
            $table->bigInteger("month");
            $table->string("patient_uid");
            $table->enum("attended", ["Yes", "No", "Pending"]);
            $table->decimal("price", 10, 2);
            $table->decimal("amount_paid", 10, 2);
            $table->string("service");
            $table->enum("status", ["Paid", "Unpaid"])->nullable();
            $table->string("procedure", 5000);
            $table->enum("procedure_visible", ["Yes", "No", "Requesting"]);
            $table->timestamps();
            $table->primary("timeslot");
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
