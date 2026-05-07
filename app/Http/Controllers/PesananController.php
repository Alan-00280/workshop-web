<?php

namespace App\Http\Controllers;

use App\Models\DetailPesananModel;
use App\Models\MenuModel;
use App\Models\PesananModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PesananController extends Controller
{
    public function getPesananByID($id)
    {
        $id = PesananModel::where('order_id', $id)->value('idpesanan');

        $isAdmin = Session::get('user_id_role') === 1;
        if ($isAdmin) {
            $menus = MenuModel::with('vendor')->get()->keyBy('idmenu');
            $detailPesanan = DetailPesananModel::all();

            $pesanan = PesananModel::where('idpesanan', $id)->first();
        } else {
            $idvendor = Session::get('idvendor');
            $menus = MenuModel::where('idvendor', $idvendor)->get()->keyBy('idmenu');
            $menuIds = $menus->keys()->toArray();

            $detailPesanan = DetailPesananModel::whereIn('idmenu', $menuIds)->where('idpesanan', $id)->get();
            $pesanan = PesananModel::where('idpesanan', $id)->first();

            $metodeId = $pesanan['metode_bayar'];
            $pesanan['metode_bayar'] = PesananModel::METODE_ID[$metodeId] ?? 'unknown';
        }

        $details = [];
        foreach ($detailPesanan as $detail) {
            $menu = $menus[$detail->idmenu] ?? null;

            $detailArray = $detail->toArray();
            $detailArray['nama_menu'] = $menu ? $menu->nama_menu : 'menu tidak ditemukan';
            if ($isAdmin && $menu && $menu->vendor) {
                $detailArray['nama_vendor'] = $menu->vendor->nama_vendor;
            }
            $details[] = $detailArray;

            // Akumulasi total
            $vendorTotal = ($vendorTotal ?? 0) + $detail->subtotal;
        }

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => [
                'pesanan' => $pesanan,
                'detail' => $details,
                'vendorTotal' => $vendorTotal
            ]
        ], 200);
    }
}
