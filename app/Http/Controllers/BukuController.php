<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    protected function validateBookData(Request $Request)  {
        return $Request->validate([
            'judul' => 'required|min:3|max:365|string',
            'pengarang' => 'required|min:3|max:365|string',
            'idkategori' => 'required|exists:kategori,idkategori'
        ]);
    }
    public function createBuku(Request $Request) {
        $validated = $this->validateBookData($Request);
        try {
            Buku::create([
                'judul' => $validated['judul'],
                'pengarang' => $validated['pengarang'],
                'idkategori' => $validated['idkategori']
            ]);
            return redirect(route('book'))->with('success', 'Sukses menambahkan buku');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: '.$e->getMessage());
        }
    }

    public function updateBuku(Request $Request) {
        $validated = $this->validateBookData($Request);
        try {
            $buku = Buku::findOrFail($Request['idbuku']);
            $buku->update([
                'judul' => $validated['judul'],
                'pengarang' => $validated['pengarang'],
                'idkategori' => $validated['idkategori']
            ]);

            return redirect(route('book'))->with('success', 'Berhasil Edit Buku');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: '.$e->getMessage());
        }
    }

    public function deleteBuku($id) {
        try {
            $buku = Buku::findOrFail($id);
            $buku->delete();
            return redirect(route('book'))->with('success', 'Berhasil Hapus Buku');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: '.$e->getMessage());
        }
    }
}
