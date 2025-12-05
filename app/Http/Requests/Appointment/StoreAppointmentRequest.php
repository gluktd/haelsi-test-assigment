<?php

namespace App\Http\Requests\Appointment;

use App\Enums\AppointmentTypeEnum;
use App\Enums\VisitFormatEnum;
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
            'customer_email' => ['required', 'email'],
            'customer_phone_number' => ['nullable', 'string', 'max:50'],
            'start_date_time' => ['required', 'date'],
            'end_date_time' => ['sometimes', 'required', 'date', 'after:start_date_time'],
            'visit_format' => ['required', new Enum(VisitFormatEnum::class)],
            'appointment_type' => ['required', new Enum(AppointmentTypeEnum::class)],
            'service_id' => ['required', 'exists:services,id'],
            'health_professional_id' => ['required', 'exists:health_professionals,id'],
        ];
    }
}
