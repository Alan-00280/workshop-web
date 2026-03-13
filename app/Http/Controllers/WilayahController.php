<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProvinsiModel;
use App\Models\KotaModel;
use App\Models\KecamatanModel;
use App\Models\KelurahanModel;

class WilayahController extends Controller
{
    public function getProvinsi(Request $request)
    {
        $provinsi = ProvinsiModel::all();
        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => [
                'provinsi' => $provinsi
            ]
        ]);
    }

    public function getKota(Request $request)
    {
        $id_provinsi = $request->post('id_provinsi');
        $kota = KotaModel::where('province_id', $id_provinsi)->get();
        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => [
                'kota' => $kota
            ]
        ]);
    }

    public function getKecamatan(Request $request)
    {
        $id_kota = $request->post('id_kota');
        $kecamatan = KecamatanModel::where('regency_id', $id_kota)->get();
        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => [
                'kecamatan' => $kecamatan
            ]
        ]);
    }

    public function getKelurahan(Request $request)
    {
        $id_kecamatan = $request->post('id_kecamatan');
        $kelurahan = KelurahanModel::where('district_id', $id_kecamatan)->get();
        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => [
                'kelurahan' => $kelurahan
            ]
        ]);
    }
}
