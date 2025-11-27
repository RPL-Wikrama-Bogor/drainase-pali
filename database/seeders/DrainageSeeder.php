<?php

namespace Database\Seeders;

use App\Models\Drainage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DrainageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $data = [
            [
                'name_road' => 'Benuang - Kampai (Batas Kab. Muara Enim)',
                'road_function' => 'Jalan Lokal Primer',
                'length_sk' => 4.12,
                'length_km' => 4.12,
                'length_m' => 4116.98
            ],
            [
                'name_road' => 'Beracung Guci - Batas Kab. Muara Enim',
                'road_function' => 'Jalan Lingkungan Primer',
                'length_sk' => 3.95,
                'length_km' => 3.95,
                'length_m' => 3951.59
            ],
            [
                'name_road' => 'Jalan Gg. Masjid',
                'road_function' => 'Jalan Lingkungan Primer',
                'length_sk' => 0.80,
                'length_km' => 0.80,
                'length_m' => 796.65
            ],
            [
                'name_road' => 'Jalan Gg. Sanip',
                'road_function' => 'Jalan Lingkungan Primer',
                'length_sk' => 0.90,
                'length_km' => 0.90,
                'length_m' => 899.66
            ],
            [
                'name_road' => 'Jalan Handayani - Talang Anding - Sumberejo',
                'road_function' => 'Jalan Lingkungan Primer',
                'length_sk' => 8.86,
                'length_km' => 8.86,
                'length_m' => 8864.91
            ],
            [
                'name_road' => 'Jalan Kalimancalak',
                'road_function' => 'Jalan Lingkungan Primer',
                'length_sk' => 3.42,
                'length_km' => 3.43,
                'length_m' => 3424.11
            ],
            [
                'name_road' => 'Jalan Kebun Sayur',
                'road_function' => 'Jalan Lingkungan Primer',
                'length_sk' => 0.64,
                'length_km' => 0.64,
                'length_m' => 637.73
            ],
            [
                'name_road' => 'Jalan Lingkar Talang Gas',
                'road_function' => 'Jalan Lingkungan Primer',
                'length_sk' => 1.05,
                'length_km' => 1.05,
                'length_m' => 1053.15
            ],
            [
                'name_road' => 'Jalan Lingkar Talang Ojan',
                'road_function' => 'Jalan Lingkungan Primer',
                'length_sk' => 0.29,
                'length_km' => 0.29,
                'length_m' => 293.66
            ],
            [
                'name_road' => 'Jalan Menuju Kantor Camat Talang Ubi',
                'road_function' => 'Jalan Lingkungan Primer',
                'length_sk' => 1.42,
                'length_km' => 1.42,
                'length_m' => 1423.15
            ],

            // -----------------------
            // LANJUTAN DATA DARI PDF
            // -----------------------
            [
                'name_road' => 'Jalan Pahlawan',
                'road_function' => 'Jalan Lingkungan Primer',
                'length_sk' => 1.64,
                'length_km' => 1.64,
                'length_m' => 1643.97
            ],
            [
                'name_road' => 'Jalan Samping Slb - Talang Jawo',
                'road_function' => 'Jalan Lingkungan Primer',
                'length_sk' => 1.04,
                'length_km' => 1.04,
                'length_m' => 1040.12
            ],
            [
                'name_road' => 'Jalan Sumber Rejo',
                'road_function' => 'Jalan Lingkungan Primer',
                'length_sk' => 2.43,
                'length_km' => 2.43,
                'length_m' => 2428.10
            ],
            [
                'name_road' => 'Jalan Sungai Limpah',
                'road_function' => 'Jalan Lingkungan Primer',
                'length_sk' => 8.61,
                'length_km' => 8.61,
                'length_m' => 8611.83
            ],
            [
                'name_road' => 'Jalan Talang Jawo',
                'road_function' => 'Jalan Lingkungan Primer',
                'length_sk' => 3.15,
                'length_km' => 3.15,
                'length_m' => 3153.80
            ],
            [
                'name_road' => 'Jalan Talang Miring',
                'road_function' => 'Jalan Lingkungan Primer',
                'length_sk' => 0.80,
                'length_km' => 0.80,
                'length_m' => 799.26
            ],
            [
                'name_road' => 'Jalan Talang Subur',
                'road_function' => 'Jalan Lingkungan Primer',
                'length_sk' => 1.22,
                'length_km' => 1.22,
                'length_m' => 1220.25
            ],
            [
                'name_road' => 'Jalan Tebing Atmojo',
                'road_function' => 'Jalan Lingkungan Primer',
                'length_sk' => 0.45,
                'length_km' => 0.45,
                'length_m' => 451.30
            ],
            [
                'name_road' => 'Jalan Tebing Delima - Batas Kab. Muara Enim',
                'road_function' => 'Jalan Lingkungan Primer',
                'length_sk' => 4.68,
                'length_km' => 4.68,
                'length_m' => 4682.14
            ],
            [
                'name_road' => 'Pasar Bhayangkara - Talang Tumbur',
                'road_function' => 'Jalan Lingkungan Primer',
                'length_sk' => 5.95,
                'length_km' => 5.95,
                'length_m' => 5954.45
            ],
            [
                'name_road' => 'Sukamaju - Trans Sukamaju',
                'road_function' => 'Jalan Lingkungan Primer',
                'length_sk' => 3.10,
                'length_km' => 3.10,
                'length_m' => 3095.54
            ],
            [
                'name_road' => 'Talang Akar - Batas Kab. Muba',
                'road_function' => 'Jalan Lingkungan Primer',
                'length_sk' => 1.93,
                'length_km' => 1.93,
                'length_m' => 1927.09
            ],
            [
                'name_road' => 'Talang Akar - Desa Talang Akar',
                'road_function' => 'Jalan Lingkungan Primer',
                'length_sk' => 1.07,
                'length_km' => 1.08,
                'length_m' => 1073.46
            ],
            [
                'name_road' => 'Talang Akar - Simpang 4 Sungai Ibul',
                'road_function' => 'Jalan Lokal Primer',
                'length_sk' => 9.80,
                'length_km' => 9.53,
                'length_m' => 9531.92
            ],
        ];

        foreach ($data as $item) {
            Drainage::create($item);
        }
    }
}
