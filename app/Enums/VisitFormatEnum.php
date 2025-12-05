<?php

namespace App\Enums;

enum VisitFormatEnum: string
{
    case IN_PERSON = 'in_person';
    case TELEMEDICINE = 'telemedicine';

    public function getLabel(): string
    {
        return match ($this) {
            self::IN_PERSON => 'In Person',
            self::TELEMEDICINE => 'Telemedicine',
        };
    }
}
