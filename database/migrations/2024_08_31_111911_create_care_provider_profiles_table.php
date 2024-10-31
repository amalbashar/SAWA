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
        Schema::create('care_provider_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // استخدام enum لتحديد التخصصات
            $table->enum('specialization',  [
                // التخصصات الطبية
                'Pediatrician',        // طبيب أطفال
                'Cardiologist',        // طبيب قلب
                'ENT Specialist',      // طبيب أنف وأذن وحنجرة
                'Neurologist',         // طبيب أعصاب
                'Ophthalmologist',     // طبيب عيون
                'Endocrinologist',     // طبيب غدد صماء

                // التخصصات التأهيلية
                'Physical Therapist',      // أخصائي علاج طبيعي
                'Occupational Therapist',  // أخصائي علاج وظيفي
                'Speech and Language Therapist', // أخصائي تخاطب ولغة
                'Dietitian',               // أخصائي تغذية

                // الدعم النفسي والتعليمي
                'Psychologist',            // أخصائي علم النفس
                'Special Education Specialist', // أخصائي تعليم خاص
                'Psychiatrist',            // طبيب نفسي
                'General Practitioner',    // ممارس عام
                'Mental Health Counselor'  // مستشار صحة نفسية
            ]);

            // سيرة ذاتية
            $table->text('bio')->nullable(); // يمكن أن يكون null

            // تقديم خدمات منزلية
            $table->boolean('offers_home_services')->default(false); // افتراضيًا false

            // عنوان العيادة
            $table->string('clinic_address')->nullable(); // يمكن أن يكون null

            // وقت الإنشاء والتحديث
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('care_provider_profiles');
    }
};
