<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\MenuModel;
use App\Models\Role;
use App\Models\User;
use App\Models\VendorModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $roles = [
            ['id_role' => 1, 'role' => 'administrator'],
            ['id_role' => 2, 'role' => 'client'],
            ['id_role' => 3, 'role' => 'vendor'],
            ['id_role' => 4, 'role' => 'customer']
        ];
        foreach ($roles as $role) {
            Role::create($role);
        }

        $users = [
            [
                'name' => 'admin DB',
                'email' => 'alanreceh28@gmail.com',
                'password' => password_hash('11223344', PASSWORD_DEFAULT),
                'id_role' => 1
            ],
            [
                'name' => 'Dimas Cake and Dessert Admin',
                'email' => 'vendor@mail.com',
                'password' => password_hash('11223344', PASSWORD_DEFAULT),
                'id_role' => 3
            ],
            [
                'name' => 'Guest',
                'email' => 'guest@mail.com',
                'password' => password_hash('11223344', PASSWORD_DEFAULT),
                'id_role' => 4
            ],
        ];
        foreach ($users as $user) {
            User::factory()->create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => $user['password'],
                'id_role' => $user['id_role']
            ]);
        }

        $kategories = [
            ['nama_kategori' => 'Novel', 'kode_kategori' => 'NV'],
            ['nama_kategori' => 'Biografi', 'kode_kategori' => 'BO'],
            ['nama_kategori' => 'Komik', 'kode_kategori' => 'KM'],
        ];
        foreach ($kategories as $kategori) {
            Kategori::create($kategori);
        }

        $bukus = [
            ['idkategori' => 1, 'judul' => 'Home Sweet Loan', 'pengarang' => 'Almira Bastari'],
            ['idkategori' => 2, 'judul' => 'Mohammad Hatta, Untuk Negeriku', 'pengarang' => 'Taufik Abdullah'],
            ['idkategori' => 1, 'judul' => 'Keajaiban Toko Kelontong Namiya', 'pengarang' => 'Keigo Higashino'],
        ];
        foreach ($bukus as $buku) {
            Buku::create($buku);
        }

        $barangs = [
            ['nama' => "Buku Tulis Sidu 38 Lembar", 'harga' => 4000],
            ['nama' => "Pulpen Pilot G2", 'harga' => 8500],
            ['nama' => "Pensil 2B Faber-Castell", 'harga' => 3000],
            ['nama' => "Penghapus Staedtler", 'harga' => 4500],
            ['nama' => "Penggaris 30 cm", 'harga' => 5000],
            ['nama' => "Spidol Snowman Permanent", 'harga' => 7000],
            ['nama' => "Stabilo Boss Original", 'harga' => 12000],
            ['nama' => "Map Plastik Folio", 'harga' => 3500],
            ['nama' => "Kertas HVS A4 80gsm (1 Rim)", 'harga' => 65000],
            ['nama' => "Binder A5", 'harga' => 25000],
            ['nama' => "Lem Kertas Fox", 'harga' => 6000],
            ['nama' => "Tipe-X Kenko", 'harga' => 7500],
        ];
        foreach ($barangs as $barang) {
            Barang::create($barang);
        }

        $vendors = [
            ['nama_vendor' => 'Yunny Bakery'],
            ['nama_vendor' => 'Dimas Cake and Dessert'],
            ['nama_vendor' => 'Donut Ranny'],
        ];

        foreach ($vendors as $vendor) {
            VendorModel::create($vendor);
        }

        $menus = [
            ['nama_menu' => 'Roti Tawar', 'harga' => 15000, 'idvendor' => 1, 'path_gambar' => 'assets\images\menu_images\dimas_bakery\american-heritage-chocolate-vdx5hPQhXFk-unsplash.jpg'],
            ['nama_menu' => 'Croissant Butter', 'harga' => 13000, 'idvendor' => 1, 'path_gambar' => 'assets\images\menu_images\dimas_bakery\lore-schodts-8BNGxSAQd6M-unsplash.jpg'],
            ['nama_menu' => 'Roti Gandum', 'harga' => 13000, 'idvendor' => 1, 'path_gambar' => 'assets\images\menu_images\dimas_bakery\shayna-douglas-CQvFD9HrDyY-unsplash.jpg'],
            ['nama_menu' => 'Sourdough Bread', 'harga' => 25000, 'idvendor' => 1, 'path_gambar' => 'assets\images\menu_images\dimas_bakery\will-echols-P_l1bJQpQF0-unsplash.jpg'],

            ['nama_menu' => 'Tart Buah', 'harga' => 20000, 'idvendor' => 1, 'path_gambar' => 'assets\images\menu_images\ranny_donut\american-heritage-chocolate-vdx5hPQhXFk-unsplash.jpg'],
            ['nama_menu' => 'Lava Cake', 'harga' => 18000, 'idvendor' => 1, 'path_gambar' => 'assets\images\menu_images\ranny_donut\deva-williamson-tW0Ix_Ajg6Y-unsplash.jpg'],
            ['nama_menu' => 'Pudding Coklat', 'harga' => 12000, 'idvendor' => 1, 'path_gambar' => 'assets\images\menu_images\ranny_donut\kaouther-djouada-hcEDfkiVmMI-unsplash.jpg'],
            ['nama_menu' => 'Slice Black Forest', 'harga' => 22000, 'idvendor' => 1, 'path_gambar' => 'assets\images\menu_images\ranny_donut\renders-br-aDHbOYF5flE-unsplash.jpg'],

            ['nama_menu' => 'Donut Glazed', 'harga' => 8000, 'idvendor' => 1, 'path_gambar' => 'assets\images\menu_images\yunny_bakery\katie-rosario-QNyRp21hb5I-unsplash.jpg'],
        ];

        foreach ($menus as $menu) {
            MenuModel::create($menu);
        }
    }
}
