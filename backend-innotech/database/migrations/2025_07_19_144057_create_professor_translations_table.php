<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfessorTranslationsTable extends Migration
{
    public function up(): void
    {
        Schema::create('professor_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professor_id')->constrained('professors')->onDelete('cascade');
            $table->string('codeLang', 10);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('speciality')->nullable();
            $table->string('grade')->nullable();
            $table->unique(['professor_id', 'codeLang']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('professor_translations');
    }
}
