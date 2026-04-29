<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('degrees', function (Blueprint $table) {
            if (Schema::hasColumn('degrees', 'name')) {
                $table->dropColumn('name');
            }
        });
    }

    public function down(): void {
        Schema::table('degrees', function (Blueprint $table) {
            $table->string('name')->nullable();
        });
    }
};
