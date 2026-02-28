<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Role;
use App\Models\User;
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
            ['id_role' => 2, 'role' => 'client']
        ];
        foreach ($roles as $role) {
            Role::create($role);
        }

        User::factory()->create([
            'name' => 'admin DB',
            'email' => 'alanreceh28@gmail.com',
            'password' => password_hash('11223344', PASSWORD_DEFAULT),
            'id_role' => 1
        ]);

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
    }
}
