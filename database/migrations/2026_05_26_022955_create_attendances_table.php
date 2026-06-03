<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_session_id')->constrained('class_sessions')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->dateTime('timestamp');
            $table->enum('status', ['PRESENT', 'ABSENT'])->default('ABSENT');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
