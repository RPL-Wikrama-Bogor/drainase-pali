<?php

namespace Database\Seeders;

use App\Models\OfficeRoad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfficeRoadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'drainage_id' => 1,
                'position' => 'Kiri',
                'segment' => 1,
                'loc_x' => 314250,
                'loc_y' => 9921500,
                'status' => 'Baik',
                'type' => 'Drainase Terbuka',
                'type_of_shape' => 'Trapesium',
                'dimension' => '60 x 80 cm',
                'material' => 'Beton',
                'material_condition' => 'Baik',
                'length' => '25 m',
                'image' => 'office_road_1.jpg',
                'notes' => 'Drainase dalam kondisi baik dan berfungsi optimal.'
            ],
            [
                'drainage_id' => 1,
                'position' => 'Kanan',
                'segment' => 1,
                'loc_x' => 314270,
                'loc_y' => 9921520,
                'status' => 'Rusak Ringan',
                'type' => 'Drainase Tertutup',
                'type_of_shape' => 'Persegi',
                'dimension' => '50 x 50 cm',
                'material' => 'Beton',
                'material_condition' => 'Retak',
                'length' => '30 m',
                'image' => 'office_road_2.jpg',
                'notes' => 'Terdapat retakan pada bagian tutup drainase.'
            ],
            [
                'drainage_id' => 1,
                'position' => 'Kiri',
                'segment' => 2,
                'loc_x' => 314300,
                'loc_y' => 9921580,
                'status' => 'Baik',
                'type' => 'Drainase Terbuka',
                'type_of_shape' => 'Persegi Panjang',
                'dimension' => '70 x 90 cm',
                'material' => 'Pasangan Batu',
                'material_condition' => 'Baik',
                'length' => '40 m',
                'image' => 'office_road_3.jpg',
                'notes' => 'Saluran bersih, tidak ada sedimentasi.'
            ],
            [
                'drainage_id' => 1,
                'position' => 'Kanan',
                'segment' => 2,
                'loc_x' => 314330,
                'loc_y' => 9921600,
                'status' => 'Tersumbat',
                'type' => 'Drainase Terbuka',
                'type_of_shape' => 'Trapesium',
                'dimension' => '50 x 70 cm',
                'material' => 'Tanah',
                'material_condition' => 'Sedang',
                'length' => '15 m',
                'image' => 'office_road_4.jpg',
                'notes' => 'Saluran tersumbat oleh sampah dan tanah.'
            ],
            [
                'drainage_id' => 1,
                'position' => 'Kiri',
                'segment' => 3,
                'loc_x' => 314360,
                'loc_y' => 9921650,
                'status' => 'Rusak Berat',
                'type' => 'Drainase Tertutup',
                'type_of_shape' => 'Persegi',
                'dimension' => '50 x 50 cm',
                'material' => 'Beton',
                'material_condition' => 'Rusak Berat',
                'length' => '10 m',
                'image' => 'office_road_5.jpg',
                'notes' => 'Kerusakan parah di beberapa titik saluran.'
            ],
        ];

        foreach ($data as $item) {
            OfficeRoad::create($item);
        }
    }
}
