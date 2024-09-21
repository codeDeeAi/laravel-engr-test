<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumMethods;

enum BatchRuleEnum: string
{
    use EnumMethods;

    case SUBMISSION_DATE = 'submission_date';
    case ENCOUNTER_DATE = 'encounter_date';
}
