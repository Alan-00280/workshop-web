<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    /**
     * Simpan data customer baru.
     * Foto dikirim sebagai base64 dari canvas (modal kamera), disimpan
     * sebagai file fisik di public/foto-customer/, dan path-nya disimpan ke DB.
     */
    public function store(Request $request)
    {
        // ── Validasi ────────────────────────────────────────────────────────
        $validated = $request->validate([
            'nama'         => ['required', 'string', 'max:255'],
            'alamat'       => ['required', 'string'],
            'kelurahan_id' => ['required', 'string'],
            'kode_pos'     => ['required', 'string', 'max:10'],
            'foto_base64'  => ['nullable', 'string'],   // data:image/jpeg;base64,...
        ], [
            'nama.required'         => 'Nama lengkap wajib diisi.',
            'alamat.required'       => 'Alamat wajib diisi.',
            'kelurahan_id.required' => 'Kelurahan wajib dipilih.',
            'kode_pos.required'     => 'Kode pos wajib diisi.',
        ]);

        // ── Simpan foto (jika ada) ──────────────────────────────────────────
        $fotoPath = null;

        if (!empty($validated['foto_base64'])) {
            // Format: data:image/jpeg;base64,<data>
            [$meta, $base64Data] = explode(',', $validated['foto_base64'], 2);

            // Tentukan ekstensi dari mime type
            $mimeMatch = [];
            preg_match('/data:image\/(\w+);base64/', $meta, $mimeMatch);
            $ext = isset($mimeMatch[1]) ? strtolower($mimeMatch[1]) : 'jpg';
            if ($ext === 'jpeg') $ext = 'jpg';

            $fileName = 'customer_' . now()->format('Ymd_His') . '_' . Str::random(8) . '.' . $ext;
            $destDir  = public_path('foto-customer');

            // Buat folder jika belum ada
            if (!is_dir($destDir)) {
                mkdir($destDir, 0755, true);
            }

            file_put_contents($destDir . DIRECTORY_SEPARATOR . $fileName, base64_decode($base64Data));

            // Path yang disimpan di DB (relatif dari public/)
            $fotoPath = 'foto-customer/' . $fileName;
        }

        // ── Simpan ke database ──────────────────────────────────────────────
        CustomerModel::create([
            'nama'         => $validated['nama'],
            'alamat'       => $validated['alamat'],
            'kelurahan_id' => $validated['kelurahan_id'],
            'kode_pos'     => $validated['kode_pos'],
            'foto_path'    => $fotoPath,
        ]);

        // ── Redirect dengan pesan sukses ────────────────────────────────────
        return redirect()
            ->route('show-customer')
            ->with('success', 'Data customer berhasil disimpan.');
    }

    public function storeBlob(Request $request)
    {
        $validated = $request->validate([
            'nama'         => ['required', 'string', 'max:255'],
            'alamat'       => ['required', 'string'],
            'kelurahan_id' => ['required', 'string'],
            'kode_pos'     => ['required', 'string', 'max:10'],
            'foto_base64'  => ['nullable', 'string'],
        ]);

        $fotoBlob = null;

        if (!empty($validated['foto_base64'])) {
            // Decode base64 → binary, lalu encode sebagai hex untuk PostgreSQL bytea
            $binary   = base64_decode(explode(',', $validated['foto_base64'], 2)[1]);
            $fotoBlob = '\\x' . bin2hex($binary);
        }

        CustomerModel::create([
            'nama'         => $validated['nama'],
            'alamat'       => $validated['alamat'],
            'kelurahan_id' => $validated['kelurahan_id'],
            'kode_pos'     => $validated['kode_pos'],
            'foto_blob'    => $fotoBlob,
        ]);

        return redirect()->route('show-customer')->with('success', 'Data customer (blob) berhasil disimpan.');
    }

    public function fotoBlob($id)
    {
        $customer = CustomerModel::findOrFail($id);

        abort_if(!$customer->foto_blob, 404);

        $blob = is_resource($customer->foto_blob)
            ? stream_get_contents($customer->foto_blob)
            : $customer->foto_blob;

        return response($blob, 200)
            ->header('Content-Type', 'image/jpeg');
    }

    public function destroy($id)
    {
        $customer = CustomerModel::findOrFail($id);

        if ($customer->foto_path) {
            $filePath = public_path($customer->foto_path);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $customer->delete();

        return redirect()->route('show-customer')->with('success', 'Customer berhasil dihapus.');
    }
}
