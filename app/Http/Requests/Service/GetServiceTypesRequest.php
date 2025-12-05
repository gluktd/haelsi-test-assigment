<?php

namespace App\Http\Requests\Service;

use App\Enums\VisitFormatEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class GetServiceTypesRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'visit_type' => ['sometimes', new Enum(VisitFormatEnum::class)],
        ];
    }
}
