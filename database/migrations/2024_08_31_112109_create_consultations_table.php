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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade')->default(123)->change();
            $table->foreignId('medical_history_id')->nullable()->constrained('medical_histories')->onDelete('cascade');
            $table->dateTime('date');
            $table->enum('status', ['Scheduled', 'Completed', 'Cancelled'])->default('Scheduled');
            $table->text('notes')->nullable();
            $table->text('response')->nullable(); // لتخزين الرد
            $table->foreignId('responded_by')->nullable()->constrained('care_provider_profiles')->onDelete('set null'); // لتحديد الشخص الذي قام بالرد
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
