<?php

use App\Models\Barang;
use App\Models\Penjualan;
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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id('id_penjualan');
            $table->integer('total');
            $table->timestamps();
        });
        Schema::create('penjualan_detil', function (Blueprint $table) {
            $table->id('idpenjualan_detail');
            $table->foreignIdFor(Penjualan::class, 'id_penjualan')->constrained();
            $table->string('id_barang', 12);
            $table->foreign('id_barang')->references('id_barang')->on('barang');
            $table->integer('jumlah');
            $table->integer('subtotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_detil');
        Schema::dropIfExists('penjualan');
    }
};
