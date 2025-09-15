<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            [
                'nama_kategori' => 'Undangan',
                'deskripsi' => 'Surat undangan untuk berbagai acara dan kegiatan'
            ],
            [
                'nama_kategori' => 'Pengumuman',
                'deskripsi' => 'Surat-surat pengumuman resmi dari desa'
            ],
            [
                'nama_kategori' => 'Nota Dinas',
                'deskripsi' => 'Nota dinas untuk keperluan internal kantor'
            ],
            [
                'nama_kategori' => 'Pemberitahuan',
                'deskripsi' => 'Surat pemberitahuan untuk warga dan instansi'
            ]
        ];

        foreach ($kategoris as $kategori) {
            Kategori::updateOrCreate(
                ['nama_kategori' => $kategori['nama_kategori']], 
                $kategori
            );
        }
    }
}
