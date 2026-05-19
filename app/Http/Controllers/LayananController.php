<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index()
    {
        return Layanan::with('kategori')->latest()->paginate(10);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori_layanans,id',
        ]);

        return Layanan::create($validated)->load('kategori');
    }

    public function show($id)
    {
        return Layanan::with('kategori')->findOrFail($id);
    }

    public function getByKategoriID($id_kategori)
    {
        $layanans = Layanan::where('id_kategori', $id_kategori)->get();
        return response()->json([
            'success' => true,
            'status' => 200,
            'data' => [
                'layanans' => $layanans
            ]
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $layanan = Layanan::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'id_kategori' => 'sometimes|required|exists:kategori_layanans,id',
        ]);

        $layanan->update($validated);

        return $layanan->load('kategori');
    }

    public function destroy($id)
    {
        $layanan = Layanan::findOrFail($id);
        $layanan->delete();

        return $layanan;
    }
}
