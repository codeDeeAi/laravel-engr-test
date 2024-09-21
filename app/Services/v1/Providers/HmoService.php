<?php

declare(strict_types=1);

namespace App\Services\v1\Providers;

use App\Enums\HttpStatusEnum;
use App\Models\Hmo;

final class HmoService
{

    public function __construct()
    {
        //
    }


    /**
     * Get Autosuggestions of available HMO codes
     * 
     * @param string $search
     * @return array{
     *     status: bool,
     *     code: int,
     *     data?: \Illuminate\Database\Eloquent\Collection|array,
     *     error?: string
     * }
     */
    public function SearchHMO(
        string $search
    ): array {
        try {

            $results = Hmo::where('code', 'regexp', $search)
                ->select(['id', 'code'])
                ->limit(10)
                ->get();

            return [
                "status" => true,
                "code" => HttpStatusEnum::OK->value,
                "data" => $results
            ];
        } catch (\Throwable $th) {

            return [
                "status" => false,
                "code" => HttpStatusEnum::INTERNAL_SERVER_ERROR->value,
                "error" => $th->getMessage()
            ];
        }
    }
}
