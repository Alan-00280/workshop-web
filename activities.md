# Laporan Studi Kasus 3: Akses Kamera

## Informasi Umum

- **Mata Kuliah:** Praktikum Pemrograman Perangkat Lunak
- **Studi Kasus:** 3 — Akses Kamera
- **Teknologi:** Laravel (PHP), PostgreSQL, Bootstrap 5, JavaScript (WebRTC)

---

## 1. Menu Customer

Menu **Customer** ditambahkan pada sidebar navigasi project utama, dengan dua submenu:
- Data Customer
- Tambah Customer 1 (simpan sebagai blob)
- Tambah Customer 2 (simpan sebagai file path)

Rute yang ditambahkan di `routes/web.php` (dalam middleware group `isAdministrator`):

```php
Route::get('/customer',          [HomeController::class, 'customerShow'])->name('show-customer');
Route::get('/customer/add-v1',   [HomeController::class, 'customerCreatev1'])->name('create-v1-customer');
Route::get('/customer/add-v2',   [HomeController::class, 'customerCreatev2'])->name('create-v2-customer');
Route::post('/customer/add-v1',  [CustomerController::class, 'store'])->name('store-v1-customer');
Route::post('/customer/add-v2',  [CustomerController::class, 'storeBlob'])->name('store-v2-customer');
Route::get('/customer/{id}/foto-blob', [CustomerController::class, 'fotoBlob'])->name('customer-foto-blob');
Route::delete('/customer/{id}',  [CustomerController::class, 'destroy'])->name('destroy-customer');
```

---

## 2. Submenu: Data Customer

**File:** `resources/views/dashboard/customer/view.blade.php`

Halaman ini menampilkan tabel seluruh data customer menggunakan **DataTables** (Bootstrap 5).

### Kolom Tabel

| Kolom | Keterangan |
|---|---|
| No | Nomor urut |
| Nama Customer | Nama lengkap customer |
| Alamat Lengkap | Alamat + wilayah (kelurahan, kecamatan, kota, provinsi) |
| Kode Pos | Kode pos customer |
| Foto Customer | Thumbnail foto; klik untuk preview modal |
| Aksi | Tombol Hapus dengan konfirmasi SweetAlert |

### Fitur Foto pada Tabel

- Jika foto disimpan sebagai **file path** (`foto_path`): ditampilkan via `asset($customer->foto_path)`
- Jika foto disimpan sebagai **blob** (`foto_blob`): ditampilkan via route `customer-foto-blob/{id}` yang mengembalikan response binary `image/jpeg`
- Klik thumbnail → modal Bootstrap menampilkan foto ukuran penuh beserta nama customer

### Fitur Hapus

- Tombol **Hapus** menggunakan form `@method('DELETE')`
- Konfirmasi menggunakan **SweetAlert2** sebelum submit
- Controller menghapus file fisik (jika ada) sebelum menghapus record dari database

---

## 3. Submenu: Tambah Customer 1 (Simpan sebagai Blob)

**File:** `resources/views/dashboard/customer/create-vtwo.blade.php`  
**Controller method:** `CustomerController::storeBlob()`  
**Route:** `POST /customer/add-v2`

### Cara Kerja

Pengguna mengisi form data customer (nama, alamat, wilayah, kode pos) dan dapat mengambil foto melalui dua cara:

1. **Ambil Foto via Kamera** — membuka modal dengan live video stream menggunakan `getUserMedia` (WebRTC)
2. **Upload dari File Explorer** — memilih file gambar dari perangkat (validasi tipe `image/*`, maks 5 MB)

Foto yang dipilih dikonversi menjadi **base64 data URI** di sisi client (JavaScript), lalu dikirim sebagai `<input type="hidden" name="foto_base64">`.

### Proses Penyimpanan (Controller)

```php
$binary   = base64_decode(explode(',', $validated['foto_base64'], 2)[1]);
$fotoBlob = '\\x' . bin2hex($binary);  // Format hex literal untuk PostgreSQL bytea

CustomerModel::create([
    'nama'         => $validated['nama'],
    'alamat'       => $validated['alamat'],
    'kelurahan_id' => $validated['kelurahan_id'],
    'kode_pos'     => $validated['kode_pos'],
    'foto_blob'    => $fotoBlob,
]);
```

> **Catatan PostgreSQL:** Kolom `bytea` memerlukan format hex literal `\x<hexstring>`. Mengirim raw binary langsung menyebabkan error `invalid byte sequence for encoding "UTF8"`.

### Menampilkan Foto Blob

Route khusus `GET /customer/{id}/foto-blob` mengembalikan binary image:

```php
public function fotoBlob($id) {
    $customer = CustomerModel::findOrFail($id);
    abort_if(!$customer->foto_blob, 404);
    $blob = is_resource($customer->foto_blob)
        ? stream_get_contents($customer->foto_blob)  // PostgreSQL mengembalikan resource stream
        : $customer->foto_blob;
    return response($blob, 200)->header('Content-Type', 'image/jpeg');
}
```

---

## 4. Submenu: Tambah Customer 2 (Simpan sebagai File Path)

**File:** `resources/views/dashboard/customer/create-vone.blade.php`  
**Controller method:** `CustomerController::store()`  
**Route:** `POST /customer/add-v1`

### Cara Kerja

Form dan fitur kamera/upload sama dengan Tambah Customer 1. Perbedaannya ada pada cara penyimpanan foto.

### Proses Penyimpanan (Controller)

```php
$binary   = base64_decode(explode(',', $validated['foto_base64'], 2)[1]);
$fileName = 'customer_' . now()->format('Ymd_His') . '_' . Str::random(8) . '.' . $ext;
file_put_contents(public_path('foto-customer') . '/' . $fileName, $binary);
$fotoPath = 'foto-customer/' . $fileName;

CustomerModel::create([
    ...
    'foto_path' => $fotoPath,
]);
```

- File disimpan di direktori `public/foto-customer/`
- Hanya **path relatif** yang disimpan di database (kolom `foto_path`)
- Ditampilkan di view menggunakan `asset($customer->foto_path)`

---

## 5. Fitur Kamera (Shared — digunakan di kedua form)

Implementasi menggunakan **WebRTC `getUserMedia` API** murni (vanilla JavaScript, tanpa library tambahan).

### Alur Penggunaan

1. User klik tombol **"Ambil Foto"** → modal terbuka, kamera aktif otomatis
2. Live video ditampilkan dalam `<video>` element
3. User klik **"Ambil Foto"** di modal → frame di-capture ke `<canvas>` → preview ditampilkan
4. User dapat klik **"Ulangi"** untuk retake, atau **"Gunakan Foto"** untuk konfirmasi
5. Foto dikonfirmasi → data URI disimpan ke `<input type="hidden">`, modal ditutup, stream kamera dimatikan
6. Alternatif: tombol **"Upload Foto"** membuka file explorer (validasi tipe & ukuran di client)

### Penanganan Error Kamera

Jika `getUserMedia` gagal (izin ditolak, tidak ada kamera), pesan error ditampilkan di dalam modal.

---

## 6. Struktur Database

**Tabel:** `customers`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint (PK) | Auto increment |
| `nama` | string | Nama lengkap customer |
| `alamat` | string | Alamat detail |
| `kelurahan_id` | char(10) | FK ke tabel `reg_villages` |
| `kode_pos` | string | Kode pos |
| `foto_path` | string (nullable) | Path file foto (v2) |
| `foto_blob` | bytea (nullable) | Binary data foto (v1) |
| `created_at` | timestamp | — |
| `updated_at` | timestamp | — |

---

## 7. File yang Dimodifikasi / Dibuat

| File | Aksi | Keterangan |
|---|---|---|
| `routes/web.php` | Modified | Tambah 7 route customer |
| `app/Http/Controllers/CustomerController.php` | Modified | Tambah `store`, `storeBlob`, `fotoBlob`, `destroy` |
| `app/Models/CustomerModel.php` | Existing | Model customers, relasi ke KelurahanModel |
| `resources/views/dashboard/customer/view.blade.php` | Modified | Tabel data, modal foto, form hapus |
| `resources/views/dashboard/customer/create-vone.blade.php` | Modified | Form + kamera + upload (simpan path) |
| `resources/views/dashboard/customer/create-vtwo.blade.php` | Modified | Form + kamera + upload (simpan blob) |
| `database/migrations/..._create_customer_models_table.php` | Existing | Migrasi tabel customers |
