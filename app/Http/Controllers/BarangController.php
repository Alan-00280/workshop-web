<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function createBarang(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|min:3|max:50|string',
            'harga_barang' => 'required|integer|min:0'
        ]);

        try {
            Barang::create([
                'nama' => $validated['nama_barang'],
                'harga' => $validated['harga_barang']
            ]);

            return redirect(route('show-barang'))
                ->with('success', 'Sukses menambahkan barang');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function updateBarang(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|min:3|max:50|string',
            'harga_barang' => 'required|integer|min:0'
        ]);

        try {
            $barang = Barang::findOrFail($request['id_barang']);

            $barang->update([
                'nama' => $validated['nama_barang'],
                'harga' => $validated['harga_barang']
            ]);

            return redirect(route('show-barang'))
                ->with('success', 'Berhasil Edit Barang');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function deleteBarang(Request $request)
    {
        try {
            $barang = Barang::findOrFail($request['id_barang']);
            $barang->delete();

            return redirect(route('show-barang'))
                ->with('success', 'Berhasil Hapus Barang');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function cetakLabelShow(Request $request) {
        $item_ids = $request['to_be_print'];
        $items = Barang::whereIn('id_barang', $item_ids)->get()->toArray();
        return view(
            'dashboard.barang.cetak-label-preview', 
            [
                'items' => $items
            ]
        );
    }
}
