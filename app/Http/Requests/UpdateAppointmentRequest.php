<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\AppointmentTypeEnum;
use App\Enums\VisitFormatEnum;
use App\Models\Service;
use App\Models\HealthProfessional;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Requests\Concerns\ValidatesAppointmentBookingRules;

class UpdateAppointmentRequest extends FormRequest
{
    use ValidatesAppointmentBookingRules;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_email' => ['sometimes', 'required', 'email'],
            'customer_phone_number' => ['sometimes', 'nullable', 'string', 'max:50'],
            'health_professional_id' => ['sometimes', 'required', 'exists:health_professionals,id'],
            'service_id' => ['sometimes', 'required', 'exists:services,id'],
            'start_date_time' => ['sometimes', 'required', 'date'],
            'end_date_time' => ['sometimes', 'required', 'date', 'after:start_date_time'],
            'visit_format' => ['sometimes', 'required', new Enum(VisitFormatEnum::class)],
            'appointment_type' => ['sometimes', 'required', new Enum(AppointmentTypeEnum::class)],
            'confirmed' => ['sometimes', 'boolean'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $this->addBookingRulesValidator($validator, function () {
            // Only validate booking rules if relevant fields are present
            if (! $this->has('visit_format')) {
                return null;
            }
            // Maintain previous behavior: skip booking rules entirely if appointment_type is not provided
            if (! $this->has('appointment_type')) {
                return null;
            }

            $format = VisitFormatEnum::from($this->input('visit_format'));

            $serviceId = $this->input('service_id');
            $professionalId = $this->input('health_professional_id');

            $routeAppointment = $this->route('appointment');
            $serviceModel = $serviceId ? Service::find($serviceId) : ($routeAppointment->service ?? null);
            $professionalModel = $professionalId ? HealthProfessional::find($professionalId) : ($routeAppointment->healthProfessional ?? null);

            $appointment = AppointmentTypeEnum::from($this->input('appointment_type'));

            return [
                'format' => $format,
                'service' => $serviceModel,
                'professional' => $professionalModel,
                'appointmentType' => $appointment,
            ];
        });
    }
}
