<?php

namespace App\Http\Controllers;

use App\Models\KategoriLayanan;
use Illuminate\Http\Request;

class KategoriLayananController extends Controller
{
    public function index()
    {
        return KategoriLayanan::with('layanans')->latest()->paginate(10);
    }

    public function all()
    {
        $kategori_layanans = KategoriLayanan::all();
        return response()->json([
            'success' => true,
            'status' => 200,
            'data' => [
                'kategori_layanans' => $kategori_layanans
            ]
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kat' => 'required|string|max:255',
        ]);

        return KategoriLayanan::create($validated);
    }

    public function show($id)
    {
        return KategoriLayanan::with('layanans')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriLayanan::findOrFail($id);

        $validated = $request->validate([
            'nama_kat' => 'sometimes|required|string|max:255',
        ]);

        $kategori->update($validated);

        return $kategori->load('layanans');
    }

    public function destroy($id)
    {
        $kategori = KategoriLayanan::findOrFail($id);
        $kategori->delete();

        return $kategori;
    }
}
