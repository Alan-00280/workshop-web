<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Str;

class CategoryController extends Controller
{
    protected function validateCategoryData(Request $Request, $kode_kategori=null) {
        $uniqueKategori = $kode_kategori ? '|unique:kategori,kode_kategori' : '';
        return $Request->validate([
            'nama_kategori' => 'required|min:3|max:100|string',
            'kode_kategori_baru' => 'required|min:2|max:5'.$uniqueKategori
        ]);
    }

    protected function validateCategoryDataUpd(Request $Request) {
        return $Request->validate([
            'nama_kategori_update' => 'required|min:3|max:100|string',
            'kode_kategori' => 'required|min:2|max:5'
        ]);
    }

    public function getCategoryByID(Request $request, $id) {
        try {
            return response()->json(
                DB::select('SELECT * FROM kategori WHERE idkategori = ?', [$id])
            );
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function createCateory(Request $Request) {
        $validated = $this->validateCategoryData($Request);
        $formatted_kode_kategori = Str::upper($validated['kode_kategori_baru']);
        try {
            Kategori::create([
                'nama_kategori' => $validated['nama_kategori'],
                'kode_kategori' => $formatted_kode_kategori
            ]);
            return redirect(route('book-categories'))->with('success', 'Berhasil menambahkan kategori');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: '.$e->getMessage());
        }
    }

    public function editCategory(Request $Request) {
        // dd($Request);
        $validated = $this->validateCategoryDataUpd($Request);
        try {
            $kategori = Kategori::findOrFail($Request['idkategori']);
            $kategori->update([
                'nama_kategori' => $validated['nama_kategori_update']
            ]);
            return redirect(route('book-categories'))->with('success', 'Berhasil edit kategori');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: '.$e->getMessage());
        }
    }

    public function deleteCategory($id) {
        try {
            $kategori = Kategori::findOrFail($id);
            $kategori->delete();
            return redirect(route('book-categories'))->with('success', 'Berhasil hapus kategori!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: '.$e->getMessage());
        }
    }
}
