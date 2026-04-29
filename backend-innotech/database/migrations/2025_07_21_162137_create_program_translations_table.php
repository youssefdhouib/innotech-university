<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('program_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->string('codeLang', 5);
            $table->json('description')->nullable();
            $table->timestamps();

            $table->unique(['program_id', 'codeLang']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('program_translations');
    }
};
