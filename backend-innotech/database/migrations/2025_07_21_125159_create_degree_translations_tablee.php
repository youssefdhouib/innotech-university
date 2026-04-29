<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Supprimer la table si elle existe déjà (précaution)
        Schema::dropIfExists('degree_translations');

        Schema::create('degree_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('degree_id')->constrained()->onDelete('cascade');
            $table->string('codeLang', 5);
            $table->string('name');
            $table->timestamps();

            $table->unique(['degree_id', 'codeLang']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('degree_translations');
    }
};
