<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cartPost(Request $request)
    {
        $validated = $request->validate([
            'idmenu' => 'required|exists:menu,idmenu',
            'quantity' => 'required|int|min:1'
        ]);

        try {
            $keranjang = Keranjang::where('idmenu', $validated['idmenu'])->first();

            if ($keranjang) {
                // Jika sudah ada, tambahkan quantity
                $keranjang->update([
                    'quantity' => $keranjang->quantity + $validated['quantity']
                ]);
            } else {
                // Jika belum ada, buat record baru
                Keranjang::create([
                    'idmenu' => $validated['idmenu'],
                    'quantity' => $validated['quantity']
                ]);
            }

            return back()->with('success', 'Berhasil menambahkan ke keranjang');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function cartUpdateByArray(Request $request)
    {
        $validated = $request->validate([
            'keranjangs' => 'required|array',
            'keranjangs.*.idkeranjang' => 'required|exists:keranjang,idkeranjang',
            'keranjangs.*.idmenu' => 'required|exists:menu,idmenu',
            'keranjangs.*.quantity' => 'required|int|min:1',
        ]);

        try {
            // Hapus semua keranjang
            Keranjang::truncate();

            // Build ulang
            $newKeranjangs = collect($validated['keranjangs'])->map(function ($item) {
                return [
                    'idmenu' => $item['idmenu'],
                    'quantity' => $item['quantity'],
                ];
            })->toArray();

            Keranjang::insert($newKeranjangs);

            //Go to checkout
            return redirect()->route('checkout-show');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
