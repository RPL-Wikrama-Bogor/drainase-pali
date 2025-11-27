<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        News::create([
            'title' => 'Pemerintah Terbitkan Perpres tentang Stranas Percepatan Pembangunan Daerah Tertinggal',
            'image' => 'berita1.jpg',
            'content' => 'Strategi Nasional Percepatan Pembangunan Daerah Tertinggal yang selanjutnya disingkat Stranas...',
            'tags' => ['Berita Dinas'],
            'author' => 'M Fadhel Abyan Agra',
            'date' => '2022-07-10',
            'category' => 'Berita Dinas'
        ]);
        News::create([
            'title' => 'Buka Peluang Ekonomi Kreatif dengan Infrastuktur dan Talenta Digital',
            'image' => 'berita2.jpeg',
            'content' => 'Kepala Badan Riset dan Inovasi Nasional LT. Handoko menilai kehadiran infrastruktur 5G dapat membuk...',
            'tags' => ['Berita Dinas'],
            'author' => 'Novita FY',
            'date' => '2021-06-28',
            'category' => 'Berita Dinas'
        ]);
        News::create([
            'title' => 'Pengaruh Kemajuan Teknologi Komunikasi dan Informasi Terhadap Karakter Anak',
            'image' => 'berita3.jpg',
            'content' => 'Kehidupan manusia yang bermula dari kesederhanaan kini menjadi kehidupan yang bisa dikategorik...',
            'tags' => ['Artikel'],
            'author' => 'Novita FY',
            'date' => '2021-07-19',
            'category' => 'Artikel'
        ]);
        News::create([
            'title' => 'Raih WTP Untuk Kelima Kalinya, Presiden: Kita Ingin Gunakan Uang Rakyat dengan Baik',
            'image' => 'berita4.jpeg',
            'content' => 'Presiden Joko Widodo menerima Laporan Hasil Pemeriksaan (LHP) atas Laporan Keuangan Pemerintah Pusat...',
            'tags' => ['Berita Dinas'],
            'author' => 'Novita FY',
            'date' => '2021-06-25',
            'category' => 'Berita Dinas'
        ]);
    }
}
