<?php

namespace App\Http\Requests;

use App\Booking\BookingRules;
use App\Enums\AppointmentTypeEnum;
use App\Enums\ProfessionalTypeEnum;
use App\Enums\ServiceTypeEnum;
use App\Enums\VisitFormatEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'visit_format' => ['required', new Enum(VisitFormatEnum::class)],
            'service_type' => ['required', new Enum(ServiceTypeEnum::class)],
            'professional_type' => ['required', new Enum(ProfessionalTypeEnum::class)],
            'appointment_type' => ['required', new Enum(AppointmentTypeEnum::class)],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->fails()) {
                return;
            }

            $format = VisitFormatEnum::from($this->input('visit_format'));
            $service = ServiceTypeEnum::from($this->input('service_type'));
            $professional = ProfessionalTypeEnum::from($this->input('professional_type'));
            $appointment = AppointmentTypeEnum::from($this->input('appointment_type'));

            $allowedServices = BookingRules::allowedServiceTypeEnums($format);

            if (! in_array($service, $allowedServices, true)) {
                $validator->errors()->add(
                    'service_type',
                    'Выбранный тип услуги недоступен для выбранного формата визита.'
                );
            }

            $allowedProfessionals = BookingRules::allowedProfessionalTypeEnums($format, $service);

            if (! in_array($professional, $allowedProfessionals, true)) {
                $validator->errors()->add(
                    'professional_type',
                    'К выбранной услуге и формату визита нельзя записаться к этому специалисту.'
                );
            }

            $allowedAppointments = BookingRules::allowedAppointmentTypeEnums($format, $service);

            if (! in_array($appointment, $allowedAppointments, true)) {
                $validator->errors()->add(
                    'appointment_type',
                    'Выбранный тип записи недоступен для этой услуги и формата визита.'
                );
            }
        });
    }
}
