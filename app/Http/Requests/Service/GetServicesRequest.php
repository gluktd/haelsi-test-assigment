<?php

namespace App\Http\Requests\Service;

use App\Enums\ServiceTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class GetServicesRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['sometimes', new Enum(ServiceTypeEnum::class)],
        ];
    }
}
