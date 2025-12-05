<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentTypeEnum;
use App\Enums\ProfessionalTypeEnum;
use App\Enums\ServiceTypeEnum;
use App\Enums\VisitFormatEnum;
use App\Http\Requests\Service\GetServicesRequest;
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

    /**
     * Get list of service types
     *
     * @operationId getServiceTypes
     */
    public function getServiceTypes(GetServicesRequest $request)
    {
        $format = $request->input('visit_type');

        $allowed = match ($format) {
            VisitFormatEnum::TELEMEDICINE->value => [
                ServiceTypeEnum::CONSULTATION,
                ServiceTypeEnum::THERAPY,
            ],
            VisitFormatEnum::IN_PERSON->value => [
                ServiceTypeEnum::CONSULTATION,
                ServiceTypeEnum::DIAGNOSTICS,
                ServiceTypeEnum::PROCEDURE,
                ServiceTypeEnum::THERAPY,
                ServiceTypeEnum::SURGERY,
            ],
            default => ServiceTypeEnum::cases(),
        };
        return GenericEnumResource::collection($allowed);
    }
}
