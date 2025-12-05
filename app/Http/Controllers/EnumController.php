<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentTypeEnum;
use App\Enums\ProfessionalTypeEnum;
use App\Enums\ServiceTypeEnum;
use App\Enums\VisitFormatEnum;
use App\Http\Resources\GenericEnumResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EnumController extends Controller
{
    /**
     * Get list of visit types
     *
     * @operationId getVisitTypes
     */
    public function getVisitTypes(): AnonymousResourceCollection
    {
        return GenericEnumResource::collection(VisitFormatEnum::cases());
    }

    /**
     * Get list of appointment types
     *
     * @operationId getAppointmentTypes
     */
    public function getAppointmentTypes()
    {
        return GenericEnumResource::collection(AppointmentTypeEnum::cases());
    }

    /**
     * Get list of professional types
     *
     * @operationId getProfessionalTypes
     */
    public function getProfessionalTypes()
    {
        return GenericEnumResource::collection(ProfessionalTypeEnum::cases());
    }
}
