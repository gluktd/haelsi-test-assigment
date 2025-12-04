<?php

namespace App\Booking;

use App\Enums\AppointmentTypeEnum;
use App\Enums\ProfessionalTypeEnum;
use App\Enums\ServiceTypeEnum;
use App\Enums\VisitFormatEnum;

final class BookingRules
{
    public static function allowedServiceTypeEnums(VisitFormatEnum $format): array
    {
        return match ($format) {
            VisitFormatEnum::TELEMEDICINE => [
                ServiceTypeEnum::CONSULTATION,
                ServiceTypeEnum::THERAPY,
            ],
            VisitFormatEnum::IN_PERSON => [
                ServiceTypeEnum::CONSULTATION,
                ServiceTypeEnum::DIAGNOSTICS,
                ServiceTypeEnum::PROCEDURE,
                ServiceTypeEnum::THERAPY,
                ServiceTypeEnum::SURGERY,
            ],
        };
    }

    public static function allowedProfessionalTypeEnums(VisitFormatEnum $format, ServiceTypeEnum $service): array
    {
        return match ([$format, $service]) {
            [VisitFormatEnum::TELEMEDICINE, ServiceTypeEnum::CONSULTATION],
            [VisitFormatEnum::TELEMEDICINE, ServiceTypeEnum::THERAPY] => [
                ProfessionalTypeEnum::GENERAL_DOCTOR,
                ProfessionalTypeEnum::CARDIOLOGIST,
                ProfessionalTypeEnum::DERMATOLOGIST,
                ProfessionalTypeEnum::PSYCHOTHERAPIST,
            ],

            [VisitFormatEnum::IN_PERSON, ServiceTypeEnum::SURGERY] => [
                ProfessionalTypeEnum::SURGEON,
            ],

            [VisitFormatEnum::IN_PERSON, ServiceTypeEnum::DIAGNOSTICS] => [
                ProfessionalTypeEnum::GENERAL_DOCTOR,
                ProfessionalTypeEnum::CARDIOLOGIST,
            ],

            default => [
                ProfessionalTypeEnum::GENERAL_DOCTOR,
            ],
        };
    }

    public static function allowedAppointmentTypeEnums(VisitFormatEnum $format, ServiceTypeEnum $service): array
    {
        if ($format === VisitFormatEnum::TELEMEDICINE) {
            return [
                AppointmentTypeEnum::INITIAL,
                AppointmentTypeEnum::FOLLOW_UP,
                AppointmentTypeEnum::CONTROL,
            ];
        }

        if ($service === ServiceTypeEnum::SURGERY) {
            return [
                AppointmentTypeEnum::INITIAL,
                AppointmentTypeEnum::FOLLOW_UP,
                AppointmentTypeEnum::CONTROL,
            ];
        }

        return [
            AppointmentTypeEnum::INITIAL,
            AppointmentTypeEnum::FOLLOW_UP,
            AppointmentTypeEnum::CONTROL,
            AppointmentTypeEnum::EMERGENCY,
        ];
    }
}
