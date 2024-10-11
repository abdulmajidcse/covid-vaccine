<?php

namespace Database\Seeders;

use App\Models\VaccineCenter;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            VaccineCenter::factory()->create([
                'name' => 'Vaccine Center ' . $i,
            ]);
        }
    }
}
