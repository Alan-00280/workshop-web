<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function getCategoryByID(Request $request, $id) {
        try {
            return response()->json(
                DB::select('SELECT * FROM kategori WHERE idkategori = ?', [$id])
            );
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }
}
