<?php

namespace Database\Seeders;

use App\Models\Complaint;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComplaintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Complaint::create([
            'email' => 'test@gmail.com',
            'location' => 'Benuang - Kampai (Batas Kab. Muara Enim)',
            'notes' => 'drainasenya sudah tidak layak digunakan, beton2 penutup drainase sudah bolong-bolong dan akan menbahayakan pengguna jalan di sekitarnya, dan satu lagi banyak pengendara parkir di sekitar drainase.',
            'status' => 'Disetujui',
            'date' => '2025-04-22',
            'image' => 'complaint1.jpg'
        ]);
    }
}
