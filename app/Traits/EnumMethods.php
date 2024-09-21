<?php

declare(strict_types=1);

namespace App\Traits;

/**
 * Traits to list all methods available in enum classes
 *
 * @author Adeola Bada
 */
trait EnumMethods
{
    /**
     * Get String for request status validation
     *
     * @param  array  $exclude  - list cases to exclude from validation
     */
    public static function getStringForRequestValidation(array $exclude = []): string
    {
        $all_cases_array = collect(self::cases())->pluck('value')->all();

        if (! empty($exclude)) {
            foreach ($exclude as $exclude_value) {
                if (
                    in_array($exclude_value, $all_cases_array) &&
                    ($key = array_search($exclude_value, $all_cases_array)) !== false
                ) {
                    unset($all_cases_array[$key]);
                }
            }
        }

        return implode(',', $all_cases_array);
    }

    /**
     * Get a collection of all enum values
     */
    public static function getAll(): array
    {
        return collect(self::cases())->pluck('value')->all();
    }
}
