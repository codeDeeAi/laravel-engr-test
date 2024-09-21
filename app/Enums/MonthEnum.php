<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumMethods;

/**
 * Enums for Months of a year
 *
 * @author Adeola Bada
 */
enum MonthEnum: int
{
    use EnumMethods;

    case JANUARY = 1;
    case FEBRUARY = 2;
    case MARCH = 3;
    case APRIL = 4;
    case MAY = 5;
    case JUNE = 6;
    case JULY = 7;
    case AUGUST = 8;
    case SEPTEMBER = 9;
    case OCTOBER = 10;
    case NOVEMBER = 11;
    case DECEMBER = 12;
}
