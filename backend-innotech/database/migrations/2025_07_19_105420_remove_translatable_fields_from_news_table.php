<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('news', function (Blueprint $table) {
            if (Schema::hasColumn('news', 'title')) {
                $table->dropColumn('title');
            }
            if (Schema::hasColumn('news', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('news', 'location')) {
                $table->dropColumn('location');
            }
        });
    }

    public function down(): void {
        Schema::table('news', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('location')->nullable();
        });
    }
};
