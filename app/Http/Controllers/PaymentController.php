<?php

namespace App\Http\Controllers;

use App\Models\DetailPesananModel;
use App\Models\Keranjang;
use App\Models\PesananModel;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function goCheckOut(Request $request)
    {
        // Ambil keranjang dari DB langsung
        $keranjangs = Keranjang::with('menu')->get();

        if ($keranjangs->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Keranjang kosong');
        }

        $total = $keranjangs->sum(fn($item) => $item->menu->harga * $item->quantity);

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.sandbox_server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // Build item_details dari keranjang
        $itemDetails = $keranjangs->map(fn($item) => [
            'id' => $item->idmenu,
            'price' => $item->menu->harga,
            'quantity' => $item->quantity,
            'name' => $item->menu->nama_menu,
        ])->toArray();

        $orderId = 'ORD-' . uniqid();
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $total,
            ],
            'item_details' => $itemDetails,
            'enabled_payments' => [
                'gopay',
                'shopeepay',
                'other_qris',
                'bank_transfer',
                'credit_card',
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        $cart_items = $keranjangs;
        return view('guest.checkout', compact('cart_items', 'total', 'snapToken', 'orderId'));
    }

    public function saveOrder(Request $request)
    {
        $cart_items = $request['cart_items'];
        $orderId = $request['order_id'];

        $pesanan = PesananModel::create([
            'order_id' => $orderId,
            'nama' => $request['nama_pelanggan'],
            'nomor_meja' => $request['nomor_meja'],
            'metode_bayar' => PesananModel::METODE[$request['payment_method']],
            'catatan' => $request['catatan'],
            'total' => collect($cart_items)->sum('subtotal'),
            'status_bayar' => 1,
        ]);

        foreach ($cart_items as $item) {
            DetailPesananModel::create([
                'idpesanan' => $pesanan->idpesanan,
                'idmenu' => $item['idmenu'],
                'harga' => $item['menu']['harga'],
                'jumlah' => $item['quantity'],
                'subtotal' => $item['menu']['harga'] * $item['quantity'],
            ]);
        }

        Keranjang::truncate();

        return response()->json(['message' => 'OK']);
    }

    public function suksesShow($id) {
        $orderId = $id;
        
        $pesanan = PesananModel::where('order_id', $orderId)->first();

        if (!$pesanan) {
            return redirect('/')->with('error', 'Data pesanan tidak ditemukan.');
        }

        return view('guest.success-checkout', compact('pesanan'));
    }
}
