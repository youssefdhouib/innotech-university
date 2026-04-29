<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropTranslatableColumnsFromProfessors extends Migration
{
    public function up(): void
    {
        Schema::table('professors', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name', 'speciality', 'grade']);
        });
    }

    public function down(): void
    {
        Schema::table('professors', function (Blueprint $table) {
            $table->string('first_name');
            $table->string('last_name');
            $table->string('speciality')->nullable();
            $table->string('grade')->nullable();
        });
    }
}
