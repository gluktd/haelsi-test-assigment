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
            'start_date_time' => ['required', 'date'],
            'end_date_time' => ['required', 'date', 'after:start_date_time'],
            'visit_format' => ['required', new Enum(VisitFormatEnum::class)],
            'appointment_type' => ['required', new Enum(AppointmentTypeEnum::class), new AppointmentTypeAllowedForVisitFormat],
            'service_id' => ['required', 'exists:services,id'],
            'health_professional_id' => ['required', 'exists:health_professionals,id'],
        ];
    }

    //    protected function withValidator(Validator $validator): void
    //    {
    //        $this->addBookingRulesValidator($validator, function () {
    //            try {
    //                $format = VisitFormatEnum::from((string) $this->input('visit_format'));
    //            } catch (\ValueError) {
    //                return null; // base enum rule will catch
    //            }
    //
    //            $service = Service::query()->find($this->input('service_id'));
    //            $professional = HealthProfessional::query()->find($this->input('health_professional_id'));
    //
    //            $appointmentType = null;
    //            $apptRaw = $this->input('appointment_type');
    //            if (is_string($apptRaw)) {
    //                try {
    //                    $appointmentType = AppointmentTypeEnum::from($apptRaw);
    //                } catch (\ValueError) {
    //                    // let Enum rule handle invalid value
    //                }
    //            }
    //
    //            return [
    //                'format' => $format,
    //                'service' => $service,
    //                'professional' => $professional,
    //                'appointmentType' => $appointmentType,
    //            ];
    //        });
    //    }
}
