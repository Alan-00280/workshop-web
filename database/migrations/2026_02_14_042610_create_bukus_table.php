<?php

use App\Models\Kategori;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id('idbuku');
            $table->timestamps();
            $table->string('kode_buku', 20)->unique();
            $table->string('judul', 500);
            $table->string('pengarang', 200);
            $table->foreignIdFor(Kategori::class, 'idkategori')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
        });

        DB::unprepared("
        CREATE OR REPLACE FUNCTION generate_kode_buku_by_kategori()
        RETURNS TRIGGER AS $$
        DECLARE
            prefix TEXT;
            next_number INT;
        BEGIN
            -- Ambil kode_kategori dari tabel kategori
            SELECT kode_kategori
            INTO prefix
            FROM kategori
            WHERE idkategori = NEW.idkategori;

            -- Jika tidak ditemukan
            IF prefix IS NULL THEN
                prefix := 'XX';
            END IF;

            -- Ambil nomor terakhir berdasarkan prefix
            SELECT COALESCE(
                MAX(CAST(SUBSTRING(kode_buku FROM '[0-9]+') AS INTEGER)),
                0
            ) + 1
            INTO next_number
            FROM buku
            WHERE kode_buku LIKE prefix || '-%';

            -- Generate kode buku
            NEW.kode_buku := prefix || '-' || LPAD(next_number::TEXT, 3, '0');

            RETURN NEW;
        END;
        $$ LANGUAGE plpgsql;
        ");

        DB::unprepared("
        CREATE TRIGGER trg_generate_kode_buku
        BEFORE INSERT ON buku
        FOR EACH ROW
        EXECUTE FUNCTION generate_kode_buku_by_kategori();

        CREATE TRIGGER trg_upd_kode_buku
        BEFORE UPDATE ON buku
        FOR EACH ROW
        EXECUTE FUNCTION generate_kode_buku_by_kategori();
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("
        DROP TRIGGER IF EXISTS trg_generate_kode_buku ON buku;
        DROP TRIGGER IF EXISTS trg_upd_kode_buku ON buku;
        ");
        Schema::dropIfExists('buku');
    }
};
