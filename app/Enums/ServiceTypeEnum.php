<?php

namespace App\Enums;

enum ServiceTypeEnum: string
{
    case CONSULTATION = 'consultation';
    case DIAGNOSTICS = 'diagnostics';
    case PROCEDURE = 'procedure';
    case THERAPY = 'therapy';
    case SURGERY = 'surgery';
}
