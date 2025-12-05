<?php

use App\Enums\AppointmentTypeEnum;
use App\Enums\ProfessionalTypeEnum;
use App\Enums\ServiceTypeEnum;
use App\Enums\VisitFormatEnum;
use App\Http\Controllers\AppointmentController;
use App\Models\Appointment;
use App\Models\HealthProfessional;
use App\Models\Service;

describe(AppointmentController::class, function () {
    it('should return a list of appointments', function () {
        $response = $this->getJson('/api/appointments');

        $response->assertValidRequest()
            ->assertValidResponse(200);
    });

    it('should return a single appointment', function () {
        $service = Service::factory()->create([
            'type' => ServiceTypeEnum::CONSULTATION->value,
        ]);
        $pro = HealthProfessional::factory()->create([
            'type' => ProfessionalTypeEnum::GENERAL_DOCTOR->value,
        ]);

        $start = now()->addDay()->startOfHour();
        $end = $start->copy()->addHour();

        $appointment = Appointment::query()->create([
            'customer_email' => 'single@example.com',
            'customer_phone_number' => '555-0000',
            'health_professional_id' => $pro->id,
            'service_id' => $service->id,
            'start_date_time' => $start->toISOString(),
            'end_date_time' => $end->toISOString(),
        ]);

        $response = $this->getJson("/api/appointments/{$appointment->id}");

        $response->assertValidRequest()
            ->assertValidResponse(200);
    });

    it('should create an appointment with valid data', function (
        VisitFormatEnum $format,
        ServiceTypeEnum $serviceType,
        ProfessionalTypeEnum $proType,
        AppointmentTypeEnum $apptType,
    ) {
        $service = Service::factory()->create(['type' => $serviceType->value]);
        $pro = HealthProfessional::factory()->create(['type' => $proType->value]);

        $start = now()->addDays(2)->startOfHour();
        $end = $start->copy()->addHour();

        $payload = [
            'customer_email' => 'john.doe@example.com',
            'customer_phone_number' => '555-1234',
            'health_professional_id' => $pro->id,
            'service_id' => $service->id,
            'start_date_time' => $start->toISOString(),
            'end_date_time' => $end->toISOString(),
            'visit_format' => $format->value,
            'appointment_type' => $apptType->value,
        ];

        $response = $this->postJson('/api/appointments', $payload);

        $response->assertValidRequest()
            ->assertValidResponse(201);

        $this->assertDatabaseHas('appointments', [
            'customer_email' => $payload['customer_email'],
            'health_professional_id' => $payload['health_professional_id'],
            'service_id' => $payload['service_id'],
            'start_date_time' => $start,
            'end_date_time' => $end,
        ]);
    })->with([
        'telemedicine + consultation + general_doctor + initial' => [
            VisitFormatEnum::TELEMEDICINE,
            ServiceTypeEnum::CONSULTATION,
            ProfessionalTypeEnum::GENERAL_DOCTOR,
            AppointmentTypeEnum::INITIAL,
        ],
        'telemedicine + therapy + psychotherapist + follow_up' => [
            VisitFormatEnum::TELEMEDICINE,
            ServiceTypeEnum::THERAPY,
            ProfessionalTypeEnum::PSYCHOTHERAPIST,
            AppointmentTypeEnum::FOLLOW_UP,
        ],
        'in_person + diagnostics + cardiologist + control' => [
            VisitFormatEnum::IN_PERSON,
            ServiceTypeEnum::DIAGNOSTICS,
            ProfessionalTypeEnum::CARDIOLOGIST,
            AppointmentTypeEnum::CONTROL,
        ],
        'in_person + surgery + surgeon + initial' => [
            VisitFormatEnum::IN_PERSON,
            ServiceTypeEnum::SURGERY,
            ProfessionalTypeEnum::SURGEON,
            AppointmentTypeEnum::INITIAL,
        ],
    ]);

    it('should reject invalid appointment creation with 422', function (
        VisitFormatEnum $format,
        ServiceTypeEnum $serviceType,
        ProfessionalTypeEnum $proType,
        AppointmentTypeEnum $apptType,
    ) {
        $service = Service::factory()->create(['type' => $serviceType->value]);
        $pro = HealthProfessional::factory()->create(['type' => $proType->value]);

        $start = now()->addDays(3)->startOfHour();
        $end = $start->copy()->addHour();

        $payload = [
            'customer_email' => 'bad@example.com',
            'customer_phone_number' => '555-2222',
            'health_professional_id' => $pro->id,
            'service_id' => $service->id,
            'start_date_time' => $start->toISOString(),
            'end_date_time' => $end->toISOString(),
            'visit_format' => $format->value,
            'appointment_type' => $apptType->value,
        ];

        $response = $this->postJson('/api/appointments', $payload);

        $response->assertValidRequest();
        $response->assertStatus(422);
    })->with([
        'telemedicine + surgery service not allowed' => [
            VisitFormatEnum::TELEMEDICINE,
            ServiceTypeEnum::SURGERY,
            ProfessionalTypeEnum::SURGEON,
            AppointmentTypeEnum::INITIAL,
        ],
        'in_person + surgery with general doctor not allowed' => [
            VisitFormatEnum::IN_PERSON,
            ServiceTypeEnum::SURGERY,
            ProfessionalTypeEnum::GENERAL_DOCTOR,
            AppointmentTypeEnum::INITIAL,
        ],
        'telemedicine + therapy with EMERGENCY not allowed' => [
            VisitFormatEnum::TELEMEDICINE,
            ServiceTypeEnum::THERAPY,
            ProfessionalTypeEnum::PSYCHOTHERAPIST,
            AppointmentTypeEnum::EMERGENCY,
        ],
    ]);

    it('should reject when end_date_time is before start_date_time', function () {
        $service = Service::factory()->create(['type' => ServiceTypeEnum::CONSULTATION->value]);
        $pro = HealthProfessional::factory()->create(['type' => ProfessionalTypeEnum::GENERAL_DOCTOR->value]);

        $start = now()->addDays(4)->startOfHour();
        $end = $start->copy()->subHour(); // invalid: end before start

        $payload = [
            'customer_email' => 'time@example.com',
            'customer_phone_number' => '555-3333',
            'health_professional_id' => $pro->id,
            'service_id' => $service->id,
            'start_date_time' => $start->toISOString(),
            'end_date_time' => $end->toISOString(),
            'visit_format' => VisitFormatEnum::TELEMEDICINE->value,
            'appointment_type' => AppointmentTypeEnum::INITIAL->value,
        ];

        $response = $this->postJson('/api/appointments', $payload);

        $response->assertValidRequest();
        $response->assertStatus(422);
    });

    it('should update an existing appointment with valid data')
        ->with([
            'change times only' => function () {
                return function (Appointment $appointment) {
                    $newStart = now()->addDays(5)->startOfHour();
                    $newEnd = $newStart->copy()->addHour();

                    return [
                        'start_date_time' => $newStart->toISOString(),
                        'end_date_time' => $newEnd->toISOString(),
                        // keep booking rules out to skip extra checks
                    ];
                };
            },
            'change service/pro and provide allowed format + type' => function () {
                return function (Appointment $appointment) {
                    $service = Service::factory()->create(['type' => ServiceTypeEnum::DIAGNOSTICS->value]);
                    $pro = HealthProfessional::factory()->create(['type' => ProfessionalTypeEnum::CARDIOLOGIST->value]);

                    return [
                        'service_id' => $service->id,
                        'health_professional_id' => $pro->id,
                        'visit_format' => VisitFormatEnum::IN_PERSON->value,
                        'appointment_type' => AppointmentTypeEnum::CONTROL->value,
                    ];
                };
            },
        ])
        ->expect(function (callable $payloadFactory) {
            // create a base valid appointment
            $service = Service::factory()->create(['type' => ServiceTypeEnum::CONSULTATION->value]);
            $pro = HealthProfessional::factory()->create(['type' => ProfessionalTypeEnum::GENERAL_DOCTOR->value]);
            $start = now()->addDay()->startOfHour();
            $end = $start->copy()->addHour();
            $appointment = Appointment::query()->create([
                'customer_email' => 'update@example.com',
                'customer_phone_number' => '555-1111',
                'health_professional_id' => $pro->id,
                'service_id' => $service->id,
                'start_date_time' => $start->toISOString(),
                'end_date_time' => $end->toISOString(),
            ]);

            $payload = $payloadFactory($appointment);

            $response = $this->putJson("/api/appointments/{$appointment->id}", $payload);

            $response->assertValidRequest()
                ->assertValidResponse(200);

            $this->assertDatabaseHas('appointments', array_merge(['id' => $appointment->id], array_intersect_key($payload, array_flip([
                'customer_email', 'customer_phone_number', 'health_professional_id', 'service_id', 'start_date_time', 'end_date_time', 'confirmed',
            ]))));
        });

    it('should delete an existing appointment', function () {
        $service = Service::factory()->create(['type' => ServiceTypeEnum::CONSULTATION->value]);
        $pro = HealthProfessional::factory()->create(['type' => ProfessionalTypeEnum::GENERAL_DOCTOR->value]);

        $start = now()->addDay()->startOfHour();
        $end = $start->copy()->addHour();

        $appointment = Appointment::query()->create([
            'customer_email' => 'remove@example.com',
            'customer_phone_number' => '555-4444',
            'health_professional_id' => $pro->id,
            'service_id' => $service->id,
            'start_date_time' => $start->toISOString(),
            'end_date_time' => $end->toISOString(),
        ]);

        $response = $this->deleteJson("/api/appointments/{$appointment->id}");

        $response->assertValidRequest()
            ->assertValidResponse(204);

        $this->assertDatabaseMissing('appointments', [
            'id' => $appointment->id,
        ]);
    });
});
