<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MenuModel;
use Illuminate\Support\Facades\Session;

class MarketVendorController extends Controller
{
    public function productsVendorPatch(Request $request) {
        $validated = $request->validate([
            'idmenu' => 'required|exists:menu,idmenu',
            'nama_menu' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'path_gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        try {
            $menu = MenuModel::findOrFail($validated['idmenu']);
            
            $menu->nama_menu = $validated['nama_menu'];
            $menu->harga = $validated['harga'];

            if ($request->hasFile('path_gambar')) {
                $file = $request->file('path_gambar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/images/menu_images'), $filename);
                $menu->path_gambar = 'assets/images/menu_images/' . $filename;
            }

            $menu->save();

            return redirect(route('products-vendor-show'))->with('success', 'Data produk berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function productsVendorPut(Request $request) {
        $validated = $request->validate([
            'nama_menu' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'path_gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        try {
            $menu = new MenuModel();
            $menu->idvendor = Session::get('idvendor');
            $menu->nama_menu = $validated['nama_menu'];
            $menu->harga = $validated['harga'];
            if(isset($validated['deskripsi'])) {
                $menu->deskripsi = $validated['deskripsi'];
            }

            if ($request->hasFile('path_gambar')) {
                $file = $request->file('path_gambar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/images/menu_images'), $filename);
                $menu->path_gambar = 'assets/images/menu_images/' . $filename;
            }

            $menu->save();

            return redirect()->route('products-vendor-show')->with('success', 'Produk baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function productsVendorDelete(Request $request) {
        $validated = $request->validate([
            'idmenu' => 'required|exists:menu,idmenu'
        ]);

        try {
            $menu = MenuModel::findOrFail($validated['idmenu']);
            
            // Hapus file gambar jika ada dan merupakan file lokal (opsional)
            if ($menu->path_gambar && strpos($menu->path_gambar, 'assets/images/menu_images/') !== false) {
                $imagePath = public_path($menu->path_gambar);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $menu->delete();

            return redirect()->route('products-vendor-show')->with('success', 'Produk berhasil dihapus dari katalog!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
