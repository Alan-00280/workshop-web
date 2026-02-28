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
        Schema::create('barang', function (Blueprint $table) {
            $table->string('id_barang', 12)->primary();
            $table->string('nama', 50);
            $table->integer('harga');
            $table->timestamp('timestamp')->default(DB::raw("CURRENT_TIMESTAMP"));
        });

        DB::unprepared("
        CREATE OR REPLACE FUNCTION generate_id_barang()
        RETURNS TRIGGER AS $$
        DECLARE
            nr INTEGER DEFAULT 0;
            prefix TEXT;
        BEGIN
            nr := (
                SELECT count(id_barang)
                FROM barang
                WHERE DATE(\"timestamp\") = CURRENT_DATE
            ) + 1;
            
            prefix := 'BR-' || TO_CHAR(CURRENT_TIMESTAMP, 'YYMMDD');

            -- Generate kode
            NEW.id_barang := prefix || '-' || LPAD(nr::text, 2, '0');

            RETURN NEW;
        END;
        $$ LANGUAGE plpgsql;
        ");

        DB::unprepared("
        CREATE TRIGGER trg_generate_id_barang
        BEFORE INSERT ON barang
        FOR EACH ROW
        EXECUTE FUNCTION generate_id_barang();
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
