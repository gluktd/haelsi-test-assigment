<?php

use App\Enums\ProfessionalTypeEnum;
use App\Http\Controllers\HealthProfessionalController;
use App\Models\HealthProfessional;

describe(HealthProfessionalController::class, function () {
    it('should return a list of health professionals', function () {
        $response = $this->getJson('/api/health-professionals');

        $response->assertValidRequest()
            ->assertValidResponse(200);
    });

    it('should return a single health professional', function () {
        $pro = HealthProfessional::factory()->create();

        $response = $this->getJson("/api/health-professionals/{$pro->id}");

        $response->assertValidRequest()
            ->assertValidResponse(200);
    });

    it('should create a new health professional', function () {
        $payload = [
            'name' => 'Dr. Jane Doe',
            'type' => ProfessionalTypeEnum::GENERAL_DOCTOR->value,
        ];

        $response = $this->postJson('/api/health-professionals', $payload);

        $response->assertValidRequest()
            ->assertValidResponse(201);

        // database assertions
        $this->assertDatabaseHas('health_professionals', [
            'name' => $payload['name'],
            'type' => $payload['type'],
        ]);
    });

    it('should update an existing health professional', function () {
        $pro = HealthProfessional::factory()->create();

        $payload = [
            'name' => 'Dr. Jane Updated',
            'type' => ProfessionalTypeEnum::CARDIOLOGIST->value,
        ];

        $response = $this->putJson("/api/health-professionals/{$pro->id}", $payload);

        $response->assertValidRequest()
            ->assertValidResponse(200);

        // database assertions
        $this->assertDatabaseHas('health_professionals', [
            'id' => $pro->id,
            'name' => $payload['name'],
            'type' => $payload['type'],
        ]);

        $this->assertDatabaseMissing('health_professionals', [
            'id' => $pro->id,
            'name' => $pro->name,
            'type' => $pro->type,
        ]);
    });

    it('should delete an existing health professional', function () {
        $pro = HealthProfessional::factory()->create();

        $response = $this->deleteJson("/api/health-professionals/{$pro->id}");

        $response->assertValidRequest()
            ->assertValidResponse(204);

        // database assertions
        $this->assertDatabaseMissing('health_professionals', [
            'id' => $pro->id,
        ]);
    });
});
