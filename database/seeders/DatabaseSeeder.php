<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Buku;
use App\Models\Classes;
use App\Models\Course;
use App\Models\Kategori;
use App\Models\KategoriLayanan;
use App\Models\Layanan;
use App\Models\MenuModel;
use App\Models\Role;
use App\Models\Teacher;
use App\Models\User;
use App\Models\UserCampus;
use App\Models\VendorModel;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // $roles = [
        //     // ['id_role' => 1, 'role' => 'administrator'],
        //     // ['id_role' => 2, 'role' => 'client'],
        //     // ['id_role' => 3, 'role' => 'vendor'],
        //     // ['id_role' => 4, 'role' => 'customer'],
        //     // ['id_role' => 5, 'role' => 'sales'],
        //     // ['id_role' => 6, 'role' => 'admin-mpp'],
        //     // ['id_role' => 7, 'role' => 'teacher'],
        //     // ['id_role' => 8, 'role' => 'student'],
        // ];
        // foreach ($roles as $role) {
        //     Role::create($role);
        // }

        // $users = [
        //     // [
        //     //     'name' => 'admin DB',
        //     //     'email' => 'alanreceh28@gmail.com',
        //     //     'password' => password_hash('11223344', PASSWORD_DEFAULT),
        //     //     'id_role' => 1
        //     // ],
        //     // [
        //     //     'name' => 'Dimas Cake and Dessert Admin',
        //     //     'email' => 'dimasCakeAdmin@mail.com',
        //     //     'password' => password_hash('11223344', PASSWORD_DEFAULT),
        //     //     'id_role' => 3
        //     // ],
        //     // [
        //     //     'name' => 'Yunny Bakery',
        //     //     'email' => 'yunnyBakeryAdmin@mail.com',
        //     //     'password' => password_hash('11223344', PASSWORD_DEFAULT),
        //     //     'id_role' => 3
        //     // ],
        //     // [
        //     //     'name' => 'Donut Ranny',
        //     //     'email' => 'donutRannyAdmin@mail.com',
        //     //     'password' => password_hash('11223344', PASSWORD_DEFAULT),
        //     //     'id_role' => 3
        //     // ],
        //     // [
        //     //     'name' => 'Guest',
        //     //     'email' => 'guest@mail.com',
        //     //     'password' => password_hash('11223344', PASSWORD_DEFAULT),
        //     //     'id_role' => 4
        //     // ],
        //     // [
        //     //     'name' => 'Hermawan',
        //     //     'email' => 'mppadmin@mail.com',
        //     //     'password' => password_hash('11223344', PASSWORD_DEFAULT),
        //     //     'id_role' => 6
        //     // ],
        //     // [
        //     //     'name' => 'Kurniawan Setya',
        //     //     'email' => 'teacher@example.com',
        //     //     'password' => password_hash('11223344', PASSWORD_DEFAULT),
        //     //     'id_role' => 7
        //     // ],
        //     // [
        //     //     'name' => 'Kanthi Ningsih',
        //     //     'email' => 'teacherTwo@example.com',
        //     //     'password' => password_hash('11223344', PASSWORD_DEFAULT),
        //     //     'id_role' => 7
        //     // ],
        //     // [
        //     //     'name' => 'Budi Harianto',
        //     //     'email' => 'teacherThree@example.com',
        //     //     'password' => password_hash('11223344', PASSWORD_DEFAULT),
        //     //     'id_role' => 7
        //     // ],
        //     // [
        //     //     'name' => 'Siti Lailia',
        //     //     'email' => 'teacherFour@example.com',
        //     //     'password' => password_hash('11223344', PASSWORD_DEFAULT),
        //     //     'id_role' => 7
        //     // ],
        //     // [
        //     //     'name' => 'Mutya Ningsihrat',
        //     //     'email' => 'teacherFive@example.com',
        //     //     'password' => password_hash('11223344', PASSWORD_DEFAULT),
        //     //     'id_role' => 7
        //     // ],
        // ];
        // foreach ($users as $user) {
        //     User::factory()->create([
        //         'name' => $user['name'],
        //         'email' => $user['email'],
        //         'password' => $user['password'],
        //         'id_role' => $user['id_role']
        //     ]);
        // }

        // $kategories = [
        //     ['nama_kategori' => 'Novel', 'kode_kategori' => 'NV'],
        //     ['nama_kategori' => 'Biografi', 'kode_kategori' => 'BO'],
        //     ['nama_kategori' => 'Komik', 'kode_kategori' => 'KM'],
        // ];
        // foreach ($kategories as $kategori) {
        //     Kategori::create($kategori);
        // }

        // $bukus = [
        //     ['idkategori' => 1, 'judul' => 'Home Sweet Loan', 'pengarang' => 'Almira Bastari'],
        //     ['idkategori' => 2, 'judul' => 'Mohammad Hatta, Untuk Negeriku', 'pengarang' => 'Taufik Abdullah'],
        //     ['idkategori' => 1, 'judul' => 'Keajaiban Toko Kelontong Namiya', 'pengarang' => 'Keigo Higashino'],
        // ];
        // foreach ($bukus as $buku) {
        //     Buku::create($buku);
        // }

        // $barangs = [
        //     ['nama' => "Buku Tulis Sidu 38 Lembar", 'harga' => 4000],
        //     ['nama' => "Pulpen Pilot G2", 'harga' => 8500],
        //     ['nama' => "Pensil 2B Faber-Castell", 'harga' => 3000],
        //     ['nama' => "Penghapus Staedtler", 'harga' => 4500],
        //     ['nama' => "Penggaris 30 cm", 'harga' => 5000],
        //     ['nama' => "Spidol Snowman Permanent", 'harga' => 7000],
        //     ['nama' => "Stabilo Boss Original", 'harga' => 12000],
        //     ['nama' => "Map Plastik Folio", 'harga' => 3500],
        //     ['nama' => "Kertas HVS A4 80gsm (1 Rim)", 'harga' => 65000],
        //     ['nama' => "Binder A5", 'harga' => 25000],
        //     ['nama' => "Lem Kertas Fox", 'harga' => 6000],
        //     ['nama' => "Tipe-X Kenko", 'harga' => 7500],
        // ];
        // foreach ($barangs as $barang) {
        //     Barang::create($barang);
        // }

        // $vendors = [
        //     ['nama_vendor' => 'Yunny Bakery', 'iduser' => '3'],
        //     ['nama_vendor' => 'Dimas Cake and Dessert', 'iduser' => '2'],
        //     ['nama_vendor' => 'Donut Ranny', 'iduser' => '4'],
        // ];

        // foreach ($vendors as $vendor) {
        //     VendorModel::create($vendor);
        // }

        // $menus = [
        //     ['nama_menu' => 'Roti Tawar', 'harga' => 15000, 'idvendor' => 1, 'path_gambar' => 'assets\images\menu_images\dimas_bakery\american-heritage-chocolate-vdx5hPQhXFk-unsplash.jpg'],
        //     ['nama_menu' => 'Croissant Butter', 'harga' => 13000, 'idvendor' => 1, 'path_gambar' => 'assets\images\menu_images\dimas_bakery\lore-schodts-8BNGxSAQd6M-unsplash.jpg'],
        //     ['nama_menu' => 'Roti Gandum', 'harga' => 13000, 'idvendor' => 1, 'path_gambar' => 'assets\images\menu_images\dimas_bakery\shayna-douglas-CQvFD9HrDyY-unsplash.jpg'],
        //     ['nama_menu' => 'Sourdough Bread', 'harga' => 25000, 'idvendor' => 1, 'path_gambar' => 'assets\images\menu_images\dimas_bakery\will-echols-P_l1bJQpQF0-unsplash.jpg'],

        //     ['nama_menu' => 'Tart Buah', 'harga' => 20000, 'idvendor' => 2, 'path_gambar' => 'assets\images\menu_images\ranny_donut\american-heritage-chocolate-vdx5hPQhXFk-unsplash.jpg'],
        //     ['nama_menu' => 'Lava Cake', 'harga' => 18000, 'idvendor' => 2, 'path_gambar' => 'assets\images\menu_images\ranny_donut\deva-williamson-tW0Ix_Ajg6Y-unsplash.jpg'],
        //     ['nama_menu' => 'Pudding Coklat', 'harga' => 12000, 'idvendor' => 2, 'path_gambar' => 'assets\images\menu_images\ranny_donut\kaouther-djouada-hcEDfkiVmMI-unsplash.jpg'],
        //     ['nama_menu' => 'Slice Black Forest', 'harga' => 22000, 'idvendor' => 2, 'path_gambar' => 'assets\images\menu_images\ranny_donut\renders-br-aDHbOYF5flE-unsplash.jpg'],

        //     ['nama_menu' => 'Donut Glazed', 'harga' => 8000, 'idvendor' => 3, 'path_gambar' => 'assets\images\menu_images\yunny_bakery\katie-rosario-QNyRp21hb5I-unsplash.jpg'],
        // ];

        // foreach ($menus as $menu) {
        //     MenuModel::create($menu);
        // }

        // ==== SYSTEM ANTRTAN ==== //
        // $kat_layanan = [
        //     ['id' => 1, 'nama_kat' => 'Administrasi Kependudukan (Disdukcapil)'],
        //     ['id' => 2, 'nama_kat' => 'Perizinan dan Non-Perizinan (DPMPTSP)'],
        //     ['id' => 3, 'nama_kat' => 'Pajak Pusat (KPP Pratama)'],
        //     ['id' => 4, 'nama_kat' => 'Pajak Daerah (Bapenda)'],
        //     ['id' => 5, 'nama_kat' => 'Imigrasi'],
        //     ['id' => 6, 'nama_kat' => 'Kejaksaan / Pengadilan'],
        //     ['id' => 7, 'nama_kat' => 'Kemenkumham'],
        //     ['id' => 8, 'nama_kat' => 'Dinas Tenaga Kerja'],
        //     ['id' => 9, 'nama_kat' => 'BPJS Ketenagakerjaan'],
        //     ['id' => 10, 'nama_kat' => 'BPJS Kesehatan'],
        //     ['id' => 11, 'nama_kat' => 'Dinas Sosial'],
        //     ['id' => 12, 'nama_kat' => 'Kementerian Agama'],
        //     ['id' => 13, 'nama_kat' => 'ATR/BPN'],
        //     ['id' => 14, 'nama_kat' => 'Perbankan'],
        //     ['id' => 15, 'nama_kat' => 'PLN'],
        //     ['id' => 16, 'nama_kat' => 'PDAM'],
        //     ['id' => 17, 'nama_kat' => 'Pos Indonesia'],
        // ];

        // foreach ($kat_layanan as $item) {
        //     KategoriLayanan::updateOrCreate(
        //         ['id' => $item['id']],
        //         ['nama_kat' => $item['nama_kat']]
        //     );
        // }

        // $layanan = [
        //     ['nama' => 'KTP Elektronik (e-KTP) & KIA', 'id_kategori' => 1],
        //     ['nama' => 'Kartu Keluarga (KK)', 'id_kategori' => 1],
        //     ['nama' => 'Akta Kelahiran', 'id_kategori' => 1],
        //     ['nama' => 'Akta Kematian', 'id_kategori' => 1],
        //     ['nama' => 'Akta Pernikahan/Perceraian (Non-Muslim)', 'id_kategori' => 1],
        //     ['nama' => 'Identitas Kependudukan Digital (IKD)', 'id_kategori' => 1],

        //     ['nama' => 'Nomor Induk Berusaha (NIB)', 'id_kategori' => 2],
        //     ['nama' => 'Persetujuan Bangunan Gedung (PBG)', 'id_kategori' => 2],
        //     ['nama' => 'Izin Reklame', 'id_kategori' => 2],
        //     ['nama' => 'Izin Tenaga Kesehatan', 'id_kategori' => 2],
        //     ['nama' => 'Izin Usaha Sektoral', 'id_kategori' => 2],
        //     ['nama' => 'Surat Keterangan Rencana Kota (SKRK)', 'id_kategori' => 2],

        //     ['nama' => 'NPWP', 'id_kategori' => 3],
        //     ['nama' => 'SPT Tahunan', 'id_kategori' => 3],
        //     ['nama' => 'Konsultasi Perpajakan', 'id_kategori' => 3],

        //     ['nama' => 'Pajak Bumi dan Bangunan (PBB)', 'id_kategori' => 4],
        //     ['nama' => 'Pajak Kendaraan Bermotor', 'id_kategori' => 4],

        //     ['nama' => 'Paspor Baru', 'id_kategori' => 5],
        //     ['nama' => 'Perpanjangan Paspor', 'id_kategori' => 5],

        //     ['nama' => 'Pengambilan Tilang', 'id_kategori' => 6],
        //     ['nama' => 'Konsultasi Hukum', 'id_kategori' => 6],
        //     ['nama' => 'Surat Keterangan Tidak Pernah Dipidana', 'id_kategori' => 6],

        //     ['nama' => 'HAKI', 'id_kategori' => 7],
        //     ['nama' => 'Merek Dagang', 'id_kategori' => 7],
        //     ['nama' => 'Hak Cipta', 'id_kategori' => 7],

        //     ['nama' => 'Kartu Kuning (AK-1)', 'id_kategori' => 8],

        //     ['nama' => 'Pendaftaran BPJS Ketenagakerjaan', 'id_kategori' => 9],
        //     ['nama' => 'Klaim BPJS Ketenagakerjaan', 'id_kategori' => 9],
        //     ['nama' => 'Perubahan Data BPJS Ketenagakerjaan', 'id_kategori' => 9],

        //     ['nama' => 'Pendaftaran BPJS Kesehatan', 'id_kategori' => 10],
        //     ['nama' => 'Pembaruan Data BPJS Kesehatan', 'id_kategori' => 10],

        //     ['nama' => 'DTKS', 'id_kategori' => 11],
        //     ['nama' => 'Bantuan Sosial', 'id_kategori' => 11],

        //     ['nama' => 'Konsultasi Pernikahan', 'id_kategori' => 12],
        //     ['nama' => 'Pendaftaran Haji/Umrah', 'id_kategori' => 12],
        //     ['nama' => 'Sertifikasi Halal UMKM', 'id_kategori' => 12],

        //     ['nama' => 'Cek Sertifikat Tanah', 'id_kategori' => 13],
        //     ['nama' => 'Balik Nama Sertifikat', 'id_kategori' => 13],
        //     ['nama' => 'Konsultasi Sengketa Lahan', 'id_kategori' => 13],

        //     ['nama' => 'Pembayaran Pajak & Retribusi', 'id_kategori' => 14],
        //     ['nama' => 'Pembukaan Rekening', 'id_kategori' => 14],

        //     ['nama' => 'Pembayaran Listrik', 'id_kategori' => 15],
        //     ['nama' => 'Pasang Baru Listrik', 'id_kategori' => 15],
        //     ['nama' => 'Perubahan Daya Listrik', 'id_kategori' => 15],

        //     ['nama' => 'Pembayaran Air', 'id_kategori' => 16],
        //     ['nama' => 'Pengajuan Layanan Air', 'id_kategori' => 16],

        //     ['nama' => 'Pengiriman Dokumen', 'id_kategori' => 17],
        //     ['nama' => 'Pembelian Meterai', 'id_kategori' => 17],
        // ];

        // foreach ($layanan as $item) {
        //     Layanan::updateOrCreate(
        //         [
        //             'nama' => $item['nama'],
        //             'id_kategori' => $item['id_kategori']
        //         ],
        //         $item
        //     );
        // }

        // 1. Definisikan data guru spesifik (Ambil 3 ID terdepan dari request Anda)
        // $teacherSystemIds = ['8', '9', '10'];
        // $gelars = ['S.Kom., M.T.', 'Dr. Eng.', 'S.T., M.Cs.'];
        // // Data dummy Mata Kuliah yang akan dibagi rata ke para guru
        // $coursesData = [
        //     [
        //         ['code' => 'IF301', 'name' => 'Pemrograman Web Backend', 'desc' => 'Fokus pengembangan RESTful API dan arsitektur server.'],
        //         ['code' => 'IF309', 'name' => 'Arsitektur Perangkat Lunak', 'desc' => 'Mempelajari design pattern dan clean architecture.']
        //     ],
        //     [
        //         ['code' => 'IF302', 'name' => 'Basis Data Terdistribusi', 'desc' => 'Implementasi replikasi dan sharding database skala besar.'],
        //         ['code' => 'IF308', 'name' => 'Administrasi Sistem Cloud', 'desc' => 'Manajemen infrastruktur server berbasis cloud dan Docker.']
        //     ],
        //     [
        //         ['code' => 'IF401', 'name' => 'Kecerdasan Buatan', 'desc' => 'Pengenalan konsep machine learning dan neural networks.'],
        //         ['code' => 'IF407', 'name' => 'Pengolahan Citra Digital', 'desc' => 'Manipulasi matriks gambar dan pengenalan pola visual.']
        //     ]
        // ];
        // foreach ($teacherSystemIds as $index => $systemId) {
        //     // A. Insert ke UserCampus terlebih dahulu
        //     $userCampus = UserCampus::create([
        //         'user_system_id' => $systemId,
        //         'tanggal_lahir' => Carbon::now()->subYears(rand(32, 45))->format('Y-m-d'),
        //         'no_hp' => '0812' . rand(10000000, 99999999),
        //         'nfc_uid' => strtoupper(Str::random(8)), // NFC UID Acak untuk pengajar
        //     ]);
        //     // B. Insert ke Teacher (no_induk_teacher otomatis terisi via DB Trigger PostgreSQL)
        //     $teacher = Teacher::create([
        //         'user_campus_id' => $userCampus->id,
        //         'gelar' => $gelars[$index],
        //     ]);
        //     // C. Loop untuk membuat beberapa Course (2 buah) bagi setiap Teacher
        //     foreach ($coursesData[$index] as $cIndex => $cData) {
        //         $course = Course::create([
        //             'course_code' => $cData['code'],
        //             'name' => $cData['name'],
        //             'description' => $cData['desc'],
        //             'dosen_id' => $teacher->id,
        //         ]);
        //         // D. Loop untuk membuat beberapa Kelas (2 buah: Kelas Paralel A & B) untuk setiap Course
        //         Classes::create([
        //             'course_id' => $course->id,
        //             'name' => 'Kelas ' . $cData['code'] . ' - Paralel A',
        //             'schedule_start' => Carbon::now()->addDays($cIndex + 1)->setTime(8, 0, 0),
        //             'schedule_end' => Carbon::now()->addDays($cIndex + 1)->setTime(10, 30, 0),
        //         ]);

        //         Classes::create([
        //             'course_id' => $course->id,
        //             'name' => 'Kelas ' . $cData['code'] . ' - Paralel B',
        //             'schedule_start' => Carbon::now()->addDays($cIndex + 1)->setTime(13, 0, 0),
        //             'schedule_end' => Carbon::now()->addDays($cIndex + 1)->setTime(15, 30, 0),
        //         ]);
        //     }
        // }
    }
}
