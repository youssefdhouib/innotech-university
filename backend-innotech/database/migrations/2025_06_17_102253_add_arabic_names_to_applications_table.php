<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('first_name_ar')->nullable()->after('first_name'); // الاسم
            $table->string('last_name_ar')->nullable()->after('last_name');   // اللقب
        });
    }

    public function down(): void {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['first_name_ar', 'last_name_ar']);
        });
    }
};

