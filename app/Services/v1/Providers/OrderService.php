<?php

declare(strict_types=1);

namespace App\Services\v1\Providers;

use DateTime;
use Illuminate\Support\Facades\DB;

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
        float|int $total_items_cost,
        array $items
    ) {

        DB::beginTransaction();

        try {

            DB::commit();
            //code...
        } catch (\Throwable $th) {

            DB::rollBack();
            //throw $th;
        }
    }
}
