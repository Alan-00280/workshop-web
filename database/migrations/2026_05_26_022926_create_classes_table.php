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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('name');
            $table->dateTime('schedule_start');
            $table->dateTime('schedule_end');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
