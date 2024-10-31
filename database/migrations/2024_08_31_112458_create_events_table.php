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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('care_provider_id')->constrained('care_provider_profiles')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('date');
            $table->string('location');
            $table->integer('capacity')->nullable();

            // إضافة حقل الصورة
            $table->string('image')->nullable(); // هذا الحقل سيحفظ مسار الصورة

            // إضافة حقل الشرح القصير
            $table->text('short_description')->nullable(); // هذا الحقل للشرح القصير للأحداث

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
