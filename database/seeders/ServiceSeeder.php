<?php

namespace Database\Seeders;

use App\Enums\ServiceTypeEnum;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'General Consultation',
                'description' => 'Comprehensive health check-up and consultation.',
                'type' => ServiceTypeEnum::CONSULTATION,
            ],
            [
                'name' => 'Blood Test',
                'description' => 'Complete blood count and analysis.',
                'type' => ServiceTypeEnum::DIAGNOSTICS,
            ],
            [
                'name' => 'X-Ray Imaging',
                'description' => 'Diagnostic imaging service using X-rays.',
                'type' => ServiceTypeEnum::DIAGNOSTICS,
            ],
            [
                'name' => 'Physical Therapy Session',
                'description' => 'Rehabilitation and physical therapy services.',
                'type' => ServiceTypeEnum::THERAPY,
            ],
            [
                'name' => 'Vaccination',
                'description' => 'Immunization services for various diseases.',
                'type' => ServiceTypeEnum::PROCEDURE,
            ],
            [
                'name' => 'Planned surgery',
                'description' => 'Elective surgical procedures for various conditions.',
                'type' => ServiceTypeEnum::SURGERY,
            ],
            [
                'name' => 'Emergency surgery',
                'description' => 'Immediate medical attention for urgent health issues.',
                'type' => ServiceTypeEnum::SURGERY,
            ],
        ];
        foreach (ServiceTypeEnum::cases() as $case) {
            Service::factory()->create(['type' => $case->value]);
        }
    }
}
