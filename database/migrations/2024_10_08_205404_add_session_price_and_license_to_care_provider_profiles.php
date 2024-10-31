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
        Schema::table('care_provider_profiles', function (Blueprint $table) {
            // إضافة عمود سعر الجلسة
            $table->decimal('price', 8, 2)->after('specialization')->nullable(); // سعر الجلسة بعد عمود التخصص

            // إضافة عمود مسار الشهادة
            $table->string('certificate')->nullable()->after('clinic_address'); // الشهادة

        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('care_provider_profiles', function (Blueprint $table) {
            // إزالة الأعمدة التي تم إضافتها
            $table->dropColumn('price');
            $table->dropColumn('certificate');
        });
    }
};
