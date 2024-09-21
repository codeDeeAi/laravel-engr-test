<?php

declare(strict_types=1);

namespace App\Services\v1\Providers;

use DateTime;

final class OrderService
{

    public function __construct()
    {
        //
    }


    /**
     * Creates an Order for a provider 
     * 
     * @param string $hmo_code
     * @param string $provider
     * @param DateTime|string $encounter_date
     * @param array<array{
     *     name: string,
     *     quantity: int,
     *     sub_total: float,
     *     unit_price: float|int
     * }> $items
     */
    public function Create(
        string $hmo_code,
        string $provider,
        DateTime | string $encounter_date,
        array $items
    ) {
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
