<?php

namespace Database\Seeders;

use App\Models\HealthProfessional;
use Illuminate\Database\Seeder;

class HealthProfessionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HealthProfessional::factory(30)->create();
    }
}
