<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        $categories = [
            ['nama_kategori' => 'Programming', 'deskripsi' => 'Kategori untuk materi pemrograman dan pengembangan perangkat lunak.', 'icon' => 'code-slash', 'warna' => 'primary'],
            ['nama_kategori' => 'Database', 'deskripsi' => 'Kategori untuk materi basis data dan manajemen data.', 'icon' => 'database', 'warna' => 'success'],
            ['nama_kategori' => 'Web Design', 'deskripsi' => 'Kategori untuk materi desain web dan antarmuka pengguna.', 'icon' => 'palette', 'warna' => 'info'],
            ['nama_kategori' => 'Networking', 'deskripsi' => 'Kategori untuk materi jaringan komputer dan komunikasi data.', 'icon' => 'wifi', 'warna' => 'warning'],
            ['nama_kategori' => 'Data Science', 'deskripsi' => 'Kategori untuk materi ilmu data dan analisis statistik.', 'icon' => 'graph-up', 'warna' => 'danger'],
        ];

        foreach ($categories as $category) {
            Kategori::updateOrCreate(
                ['nama_kategori' => $category['nama_kategori']],
                $category
            );
        }
    }
}
