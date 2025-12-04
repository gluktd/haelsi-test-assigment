<?php

namespace App\Enums;

enum VisitFormatEnum: string
{
    case IN_PERSON = 'in_person';   // очно
    case TELEMEDICINE = 'telemedicine'; // онлайн
}
