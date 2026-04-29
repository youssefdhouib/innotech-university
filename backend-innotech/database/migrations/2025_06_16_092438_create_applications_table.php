<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('desired_degree_id')->nullable()->constrained('degrees')->nullOnDelete();
            $table->string('cin')->unique();
            $table->string('passport')->nullable();
            $table->date('birth_date');
            $table->string('country');
            $table->string('gender');
            $table->string('address')->nullable();
            $table->string('phone');
            $table->string('previous_degree');
            $table->integer('graduation_year');
            $table->string('how_did_you_hear');
            $table->string('status')->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('applications');
    }
};
