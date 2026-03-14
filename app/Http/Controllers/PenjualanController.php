<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'total'                        => 'required|numeric',
            'barang_checkout'              => 'required|array|min:1',
            'barang_checkout.*.id_barang'  => 'required|string|exists:barang,id_barang',
            'barang_checkout.*.jumlah'     => 'required|integer|min:1',
            'barang_checkout.*.subtotal'   => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            // 1. Create Penjualan header
            $penjualan = Penjualan::create([
                'total' => $request->total,
            ]);

            // 2. Insert each item as PenjualanDetail
            $details = [];
            foreach ($request->barang_checkout as $item) {
                $details[] = [
                    'id_penjualan' => $penjualan->id_penjualan,
                    'id_barang'    => $item['id_barang'],
                    'jumlah'       => $item['jumlah'],
                    'subtotal'     => $item['subtotal'],
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ];
            }

            PenjualanDetail::insert($details);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil disimpan.',
                'data'    => $penjualan->load('PenjualanDetail'),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Transaksi gagal: ' . $e->getMessage(),
            ], 500);
        }
    }
}
