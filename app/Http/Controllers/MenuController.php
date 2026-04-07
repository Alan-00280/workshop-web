<?php

namespace App\Http\Controllers;

use App\Models\MenuModel;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function filterMenu(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'nullable|string',
            'idvendor' => 'nullable|exists:vendor,idvendor',
            'max_price' => 'nullable|numeric|min:0',
            'page' => 'nullable|integer|min:1',
        ]);

        $menus = MenuModel::with('vendor')
            ->when($validated['nama'] ?? null, function ($query, $nama) {
                $query->whereRaw('LOWER(nama_menu) LIKE ?', ['%' . strtolower($nama) . '%']);
            })
            ->when($validated['idvendor'] ?? null, fn($q, $v) => $q->where('idvendor', $v))
            ->when($validated['max_price'] ?? null, fn($q, $v) => $q->where('harga', '<=', $v))
            ->paginate(8);

        return response()->json([
            'success' => true,
            'data' => $menus->items(),
            'pagination' => [
                'current_page' => $menus->currentPage(),
                'last_page' => $menus->lastPage(),
                'total' => $menus->total(),
            ]
        ]);
    }
}
