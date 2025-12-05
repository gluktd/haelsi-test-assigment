<?php

namespace App\Http\Requests\HealthProfessional;

use App\Enums\ProfessionalTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class GetHealthProfessionalsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['sometimes', new Enum(ProfessionalTypeEnum::class)],
        ];
    }
}
