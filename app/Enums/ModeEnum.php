<?php

namespace App\Enums;

enum ModeEnum: string
{
    case PRESENTIEL = 'Présentiel';
    case DISTANCIEL = 'Distanciel';
    case MIXTE = 'Mixte';
}
