<?php

namespace App\Http\Requests\Concerns;

use App\Booking\BookingRules;
use App\Enums\AppointmentTypeEnum;
use App\Enums\ProfessionalTypeEnum;
use App\Enums\ServiceTypeEnum;
use App\Enums\VisitFormatEnum;
use App\Models\HealthProfessional;
use App\Models\Service;
use Illuminate\Contracts\Validation\Validator;

/**
 * Shared booking rules validator for Appointment requests.
 *
 * Implementations should call addBookingRulesValidator in withValidator()
 * and provide a resolver that returns an array context or null to skip.
 *
 * Context array keys:
 * - format: VisitFormatEnum
 * - service: Service
 * - professional: HealthProfessional
 * - appointmentType: AppointmentTypeEnum
 */
trait ValidatesAppointmentBookingRules
{
    /**
     * Attach common BookingRules validation to the given validator.
     *
     * @param callable(): (array{
     *   format: VisitFormatEnum,
     *   service: Service|null,
     *   professional: HealthProfessional|null,
     *   appointmentType: AppointmentTypeEnum|null,
     * }|null) $resolveContext Returns context or null to skip validation
     */
    protected function addBookingRulesValidator(Validator $validator, callable $resolveContext): void
    {
        $validator->after(function (Validator $validator) use ($resolveContext) {
            if ($validator->fails()) {
                return;
            }
            $ctx = $resolveContext();
            if ($ctx === null) {
                return;
            }

            /** @var VisitFormatEnum $format */
            $format = $ctx['format'] ?? null;
            /** @var Service|null $serviceModel */
            $serviceModel = $ctx['service'] ?? null;
            /** @var HealthProfessional|null $professionalModel */
            $professionalModel = $ctx['professional'] ?? null;
            /** @var AppointmentTypeEnum|null $appointment */
            $appointment = $ctx['appointmentType'] ?? null;

            if (! $format instanceof VisitFormatEnum) {
                return;
            }

            if (! $serviceModel || ! $professionalModel) {
                return;
            }

            $service = ServiceTypeEnum::from($serviceModel->type);
            $professional = ProfessionalTypeEnum::from($professionalModel->type);

            $allowedServices = BookingRules::allowedServiceTypeEnums($format);
            if (! in_array($service, $allowedServices, true)) {
                $validator->errors()->add(
                    'service_id',
                    'Выбранный тип услуги недоступен для выбранного формата визита.'
                );
            }

            $allowedProfessionals = BookingRules::allowedProfessionalTypeEnums($format, $service);
            if (! in_array($professional, $allowedProfessionals, true)) {
                $validator->errors()->add(
                    'health_professional_id',
                    'К выбранной услуге и формату визита нельзя записаться к этому специалисту.'
                );
            }

            if ($appointment instanceof AppointmentTypeEnum) {
                $allowedAppointments = BookingRules::allowedAppointmentTypeEnums($format, $service);
                if (! in_array($appointment, $allowedAppointments, true)) {
                    $validator->errors()->add(
                        'appointment_type',
                        'Выбранный тип записи недоступен для этой услуги и формата визита.'
                    );
                }
            }
        });
    }
}
