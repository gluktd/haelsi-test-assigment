<?php

use App\Enums\ServiceTypeEnum;
use App\Http\Controllers\ServiceController;
use App\Models\Service;

describe(ServiceController::class, function () {
    it('should return a list of services', function () {
        $response = $this->getJson('/api/services');

        $response->assertValidRequest()
            ->assertValidResponse(200);
    });
    it('should return a single service', function () {
        $service = Service::factory()->create();

        $response = $this->getJson("/api/services/{$service->id}");

        $response->assertValidRequest()
            ->assertValidResponse(200);
    });
    it('should create a new service', function () {
        $payload = [
            'name' => 'Initial Consultation',
            'description' => 'First time consultation and assessment.',
            'type' => ServiceTypeEnum::CONSULTATION->value,
        ];

        $response = $this->postJson('/api/services', $payload);

        $response->assertValidRequest()
            ->assertValidResponse(201);

        // database assertions
        $this->assertDatabaseHas('services', [
            'name' => $payload['name'],
            'description' => $payload['description'],
            'type' => $payload['type'],
        ]);
    });
    it('should update an existing service', function () {
        $service = Service::factory()->create();

        $payload = [
            'name' => 'Updated Name',
            'description' => 'Updated description goes here.',
            'type' => ServiceTypeEnum::THERAPY->value,
        ];

        $response = $this->putJson("/api/services/{$service->id}", $payload);

        $response->assertValidRequest()
            ->assertValidResponse(200);

        // database assertions
        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'name' => $payload['name'],
            'description' => $payload['description'],
            'type' => $payload['type'],
        ]);

        $this->assertDatabaseMissing('services', [
            'id' => $service->id,
            'name' => $service->name,
            'description' => $service->description,
            'type' => $service->type,
        ]);
    });
    it('should delete an existing service', function () {
        $service = Service::factory()->create();

        $response = $this->deleteJson("/api/services/{$service->id}");

        $response->assertValidRequest()
            ->assertValidResponse(204);

        // database assertions
        $this->assertDatabaseMissing('services', [
            'id' => $service->id,
        ]);
    });
    it('should return a list of services for a health professional', function () {
        // Not defined in the current OpenAPI spec; skipping to keep tests aligned with Spectator definitions.
        $this->markTestSkipped('Endpoint not defined in the API specification.');
    });
});
