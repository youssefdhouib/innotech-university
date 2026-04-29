<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('department_translations', function (Blueprint $table) {
            $table->id();

            // Foreign key to departments
            $table->foreignId('department_id')
                ->constrained()
                ->onDelete('cascade');

            // Language code
            $table->string('codeLang', 5); // e.g. 'fr', 'en', 'ar'

            // Translatable fields
            $table->string('name');
            $table->text('description')->nullable();

            $table->timestamps();

            // Unique constraint to avoid duplicate translations per language
            $table->unique(['department_id', 'codeLang']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('department_translations');
    }
};
