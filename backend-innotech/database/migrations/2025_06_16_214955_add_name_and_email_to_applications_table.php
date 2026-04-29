<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('first_name')->after('id');
            $table->string('last_name')->after('first_name');
            $table->string('email')->after('last_name');
        });
    }

    public function down(): void {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name', 'email']);
        });
    }
};
