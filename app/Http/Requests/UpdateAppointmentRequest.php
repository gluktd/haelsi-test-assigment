<?php

namespace App\Http\Requests;

use App\Enums\AppointmentTypeEnum;
use App\Enums\VisitFormatEnum;
use App\Models\HealthProfessional;
use App\Models\Service;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateAppointmentRequest extends FormRequest
{

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
}
