<?php

namespace App\Rules;

use App\Booking\BookingRules;
use App\Enums\AppointmentTypeEnum;
use App\Enums\ServiceTypeEnum;
use App\Enums\VisitFormatEnum;
use App\Models\Service;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Validates that the selected appointment_type is allowed for a given visit_format
 * (and optionally service type, if service_id is present).
 */
class AppointmentTypeAllowedForVisitFormat implements DataAwareRule, ValidationRule
{
    /** @var array<string, mixed> */
    protected array $data = [];

    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Validate the attribute.
     *
     * @param  \Closure(string): void  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $formatRaw = $this->data['visit_format'] ?? null;
        if (! is_string($formatRaw)) {
            return;
        }

        if (! is_string($value)) {
            return;
        }

        try {
            $format = VisitFormatEnum::from($formatRaw);
        } catch (\ValueError) {
            return; // other rules will report invalid format
        }

        try {
            $apptType = AppointmentTypeEnum::from($value);
        } catch (\ValueError) {
            return;
        }

        // If service_id provided, refine allowed list by service type
        $serviceType = null;
        $serviceId = $this->data['service_id'] ?? null;
        if (is_numeric($serviceId)) {
            /** @var Service|null $service */
            $service = Service::query()->select('id', 'type')->find($serviceId);
            if ($service) {
                try {
                    $serviceType = ServiceTypeEnum::from($service->type);
                } catch (\ValueError) {
                    $serviceType = null;
                }
            }
        }

        $allowed = BookingRules::allowedAppointmentTypeEnums($format, $serviceType ?? ServiceTypeEnum::CONSULTATION);

        if (! in_array($apptType, $allowed, true)) {
            $fail('Выбранный тип записи недоступен для выбранного формата визита.');
        }
    }
}
