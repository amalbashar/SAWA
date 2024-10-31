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
            Schema::create('advice', function (Blueprint $table) {
                $table->id(); // العمود الأساسي للنصيحة
                $table->foreignId('care_provider_profile_id')->constrained('care_provider_profiles')->onDelete('cascade'); // الربط بجدول care_provider_profiles
                $table->text('content'); // محتوى النصيحة
                $table->timestamps(); // لحفظ وقت الإنشاء والتحديث
            });
        }

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advice');
    }
};
