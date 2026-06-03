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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_campus_id')->constrained('user_campuses')->onDelete('cascade');
            $table->string('no_induk_teacher', 11)->unique()->nullable(); // dibuat nullable untuk diisi trigger
            $table->string('gelar');
            $table->timestamps();
        });
        // Raw SQL Trigger untuk PostgreSQL
        DB::unprepared('
            CREATE OR REPLACE FUNCTION generate_teacher_no_induk()
            RETURNS TRIGGER AS $$
            DECLARE
            current_year TEXT;
            next_seq INT;
            BEGIN
            IF NEW.no_induk_teacher IS NULL THEN
            current_year := TO_CHAR(NOW(), \'YYYY\');
            SELECT COALESCE(MAX(SUBSTRING(no_induk_teacher FROM 5 FOR 7)::INT), 0) + 1
            INTO next_seq
            FROM teachers
            WHERE no_induk_teacher LIKE current_year || \'%\';
            -- Format: TAHUN (4 digit) + URUTAN (7 digit) = 11 Digit
            NEW.no_induk_teacher := current_year || LPAD(next_seq::TEXT, 7, \'0\');
            END IF;
            RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
            CREATE TRIGGER trigger_teacher_no_induk
            BEFORE INSERT ON teachers
            FOR EACH ROW
            EXECUTE FUNCTION generate_teacher_no_induk();
        ');
    }
    /**
    * Drop the migrations.
    */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trigger_teacher_no_induk ON teachers;');
        DB::unprepared('DROP FUNCTION IF EXISTS generate_teacher_no_induk();');
        Schema::dropIfExists('teachers');
    }
};
