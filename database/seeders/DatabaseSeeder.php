<?php

namespace Database\Seeders;

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
            'name' => 'admin_DB',
            'email' => 'admin@mail.com',
            'password' => password_hash('11223344', PASSWORD_DEFAULT),
            'id_role' => 1
        ]);

        $kategories = [
            ['nama_kategori' => 'Novel'],
            ['nama_kategori' => 'Biografi'],
            ['nama_kategori' => 'Komik'],
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
    }
}
