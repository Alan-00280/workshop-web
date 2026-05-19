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
        Schema::create('antrians', function (Blueprint $table) {
            $table->id();
            $table->integer('no_urut')->nullable(); 
            $table->date('tanggal')->nullable();  
            $table->timestamp('waktu_daftar')->nullable();
            $table->enum('status', ['waiting', 'called', 'late', 'done'])
                ->default('waiting');
            $table->string('nama');
            $table->foreignId('id_layanan')
                ->constrained('layanans')
                ->cascadeOnDelete();
            $table->timestamps();
            
            $table->unique(['no_urut', 'id_layanan', 'tanggal']);
        });

        // function set no urut
        DB::statement("
            CREATE OR REPLACE FUNCTION set_no_antrian()
            RETURNS TRIGGER AS $$
            DECLARE
                last_no INTEGER;
                kategori_id INTEGER;
            BEGIN
                -- set otomatis
                NEW.tanggal := CURRENT_DATE;
                NEW.waktu_daftar := NOW();

                -- ambil kategori dari layanan
                SELECT id_kategori INTO kategori_id
                FROM layanans
                WHERE id = NEW.id_layanan;

                -- ambil nomor terakhir berdasarkan kategori & tanggal
                SELECT COALESCE(MAX(a.no_urut), 0)
                INTO last_no
                FROM antrians a
                JOIN layanans l ON a.id_layanan = l.id
                WHERE l.id_kategori = kategori_id
                AND a.tanggal = CURRENT_DATE;

                -- set nomor urut
                NEW.no_urut := last_no + 1;

                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ");

        // trigger
        DB::statement("
            CREATE TRIGGER trg_set_no_antrian
            BEFORE INSERT ON antrians
            FOR EACH ROW
            EXECUTE FUNCTION set_no_antrian();
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP TRIGGER IF EXISTS trg_set_no_antrian ON antrians;");
        DB::statement("DROP FUNCTION IF EXISTS set_no_antrian;");
        Schema::dropIfExists('antrians');
    }
};
