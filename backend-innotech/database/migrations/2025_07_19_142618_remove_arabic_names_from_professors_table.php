<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('professors', function (Blueprint $table) {
            if (Schema::hasColumn('professors', 'first_name_ar')) {
                $table->dropColumn('first_name_ar');
            }
            if (Schema::hasColumn('professors', 'last_name_ar')) {
                $table->dropColumn('last_name_ar');
            }
        });
    }

    public function down(): void {
        Schema::table('professors', function (Blueprint $table) {
            $table->string('first_name_ar')->nullable();
            $table->string('last_name_ar')->nullable();
        });
    }
};
