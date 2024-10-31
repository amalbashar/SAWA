<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('care_provider_profiles', function (Blueprint $table) {
            $table->string('profile_image')->nullable()->after('bio'); // إضافة عمود للصورة، بعد عمود السيرة الذاتية
        });
    }

    public function down()
    {
        Schema::table('care_provider_profiles', function (Blueprint $table) {
            $table->dropColumn('profile_image'); // حذف العمود في حال التراجع
        });
    }

};
