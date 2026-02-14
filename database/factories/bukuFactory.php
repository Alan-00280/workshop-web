<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Buku;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\buku>
 */
class bukuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Buku::class;

    public function definition(): array
    {
        return [
            'kode_buku' => $this->faker->unique()->bothify('BK-??###'),
            'judul' => fake()->randomElement([
                'Jejak Langkah di Ujung Senja',
                'Rahasia di Balik Kabut Pagi',
                'Algoritma Cinta dan Logika',
                'Misteri Perpustakaan Tua',
                'Langit yang Tak Pernah Sama',
                'Catatan Seorang Pengembara',
                'Bayangan di Kota Hujan',
                'Pelukis Waktu',
                'Di Antara Dua Dunia',
                'Simfoni Hujan dan Kenangan',
                'Kode Terakhir Sang Ilmuwan',
                'Perjalanan Menuju Titik Nol',
                'Senyap di Balik Cahaya',
                'Fragmen Masa Lalu',
                'Detik yang Tak Kembali'
            ])
        ];
    }
}
