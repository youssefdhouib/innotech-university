<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('professors', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('speciality')->nullable();
            $table->string('grade')->nullable();
            $table->string('profile_slug')->unique();
            $table->string('photo_url')->nullable();
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->string('cv_attached_file')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('professors');
    }
};
