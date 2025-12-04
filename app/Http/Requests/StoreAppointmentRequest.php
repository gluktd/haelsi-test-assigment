<?php

namespace App\Http\Requests;

use App\Enums\AppointmentTypeEnum;
use App\Enums\VisitFormatEnum;
use App\Http\Requests\Concerns\ValidatesAppointmentBookingRules;
use App\Models\HealthProfessional;
use App\Models\Service;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreAppointmentRequest extends FormRequest
{
    use ValidatesAppointmentBookingRules;
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_email' => ['required', 'email'],
            'customer_phone_number' => ['nullable', 'string', 'max:50'],
            'health_professional_id' => ['required', 'exists:health_professionals,id'],
            'service_id' => ['required', 'exists:services,id'],
            'start_date_time' => ['required', 'date'],
            'end_date_time' => ['required', 'date', 'after:start_date_time'],
            'visit_format' => ['required', new Enum(VisitFormatEnum::class)],
            'appointment_type' => ['required', new Enum(AppointmentTypeEnum::class)],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $this->addBookingRulesValidator($validator, function () {
            // For store, required fields validated by rules(), so safe to resolve directly
            $format = VisitFormatEnum::from($this->input('visit_format'));
            $serviceModel = Service::find($this->input('service_id'));
            $professionalModel = HealthProfessional::find($this->input('health_professional_id'));
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
