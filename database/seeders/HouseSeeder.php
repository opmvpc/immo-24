<?php

namespace Database\Seeders;

use App\Models\House;
use App\Models\Photo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        House::factory()
            ->count(25)
            ->has(Photo::factory()->count(5))
            ->create();
    }
}
