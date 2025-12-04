<?php

namespace App\Enums;

enum ProfessionalTypeEnum: string
{
    case GENERAL_DOCTOR = 'general_doctor';
    case CARDIOLOGIST = 'cardiologist';
    case DERMATOLOGIST = 'dermatologist';
    case GYNECOLOGIST = 'gynecologist';
    case PEDIATRICIAN = 'pediatrician';
    case SURGEON = 'surgeon';
    case PSYCHOTHERAPIST = 'psychotherapist';
    case PHYSIOTHERAPIST = 'physiotherapist';
}
