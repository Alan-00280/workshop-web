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
        Schema::create('user_campuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_system_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal_lahir');
            $table->string('no_hp', 12);
            $table->string('nfc_uid')->unique()->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('user_campuses');
    }
};
