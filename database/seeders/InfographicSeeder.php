<?php

namespace Database\Seeders;

use App\Models\Infographics;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InfographicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Infographics::create([
            'image' => 'info1.jpg'
        ]);
        Infographics::create([
            'image' => 'info2.jpeg'
        ]);
        Infographics::create([
            'image' => 'info3.png'
        ]);
    }
}
