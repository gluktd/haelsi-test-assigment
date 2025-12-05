<?php

namespace App\Http\Requests;

use App\Enums\AppointmentTypeEnum;
use App\Enums\VisitFormatEnum;
use App\Http\Requests\Concerns\ValidatesAppointmentBookingRules;
use App\Models\HealthProfessional;
use App\Models\Service;
use App\Rules\AppointmentTypeAllowedForVisitFormat;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

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
            'appointment_type' => ['sometimes', 'required', new Enum(AppointmentTypeEnum::class), new AppointmentTypeAllowedForVisitFormat],
            'confirmed' => ['sometimes', 'boolean'],
        ];
    }

    protected function withValidator(Validator $validator): void
    {
        $this->addBookingRulesValidator($validator, function () {
            $formatRaw = $this->input('visit_format');
            $serviceId = $this->input('service_id');
            $proId = $this->input('health_professional_id');

            // Only validate booking rules on update if all booking inputs are present
            if (! is_string($formatRaw) || ! is_numeric($serviceId) || ! is_numeric($proId)) {
                return null;
            }

            try {
                $format = VisitFormatEnum::from($formatRaw);
            } catch (\ValueError) {
                return null;
            }

            $service = Service::query()->find($serviceId);
            $professional = HealthProfessional::query()->find($proId);

            $appointmentType = null;
            $apptRaw = $this->input('appointment_type');
            if (is_string($apptRaw)) {
                try {
                    $appointmentType = AppointmentTypeEnum::from($apptRaw);
                } catch (\ValueError) {
                    // let Enum rule handle
                }
            }

            return [
                'format' => $format,
                'service' => $service,
                'professional' => $professional,
                'appointmentType' => $appointmentType,
            ];
        });
    }
}
