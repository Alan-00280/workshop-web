<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_campus_id')->constrained('user_campuses')->onDelete('cascade');
            $table->string('no_induk', 11)->unique()->nullable(); // dibuat nullable agar trigger bisa mengisi otomatis
            $table->string('program');
            $table->timestamps();
        });
        // Raw SQL Trigger untuk PostgreSQL
        DB::unprepared('
            CREATE OR REPLACE FUNCTION generate_student_no_induk()
            RETURNS TRIGGER AS $$
            DECLARE
            current_year TEXT;
            next_seq INT;
            BEGIN
            -- Cek jika no_induk tidak diisi saat insert
            IF NEW.no_induk IS NULL THEN
            current_year := TO_CHAR(NOW(), \'YYYY\');
            -- Mengambil urutan terakhir pada tahun berjalan
            SELECT COALESCE(MAX(SUBSTRING(no_induk FROM 5 FOR 7)::INT), 0) + 1
            INTO next_seq
            FROM students
            WHERE no_induk LIKE current_year || \'%\';
            -- Format: TAHUN (4 digit) + URUTAN (7 digit padding nol) = 11 Digit
            NEW.no_induk := current_year || LPAD(next_seq::TEXT, 7, \'0\');
            END IF;
            RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
            CREATE TRIGGER trigger_student_no_induk
            BEFORE INSERT ON students
            FOR EACH ROW
            EXECUTE FUNCTION generate_student_no_induk();
        ');
    }
    // Reverse
    public function down(): void
    {
        // Drop trigger dan function terlebih dahulu sebelum menghapus tabel
        DB::unprepared('DROP TRIGGER IF EXISTS trigger_student_no_induk ON students;');
        DB::unprepared('DROP FUNCTION IF EXISTS generate_student_no_induk();');
        Schema::dropIfExists('students');
    }
};
