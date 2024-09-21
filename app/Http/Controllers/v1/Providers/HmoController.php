<?php

namespace App\Http\Controllers\v1\Providers;

use App\Enums\HttpStatusEnum;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\v1\Providers\HmoService;
use App\Http\Requests\v1\Providers\SearchHmoRequest;

class HmoController extends Controller
{
    /**
     * Get HMO suggestions when creating orders
     * 
     * @return JsonResponse
     */
    public function search(SearchHmoRequest $request): JsonResponse
    {
        try {
            $search = $request->search;

            $result = (new HmoService())->SearchHMO($search);

            if (!$result['status'])
                return response()
                    ->json(['result' => $result['data']], $result['code']);

            return response()
                ->json(['error' => $result['error']], $result['code']);
        } catch (\Throwable $th) {

            return response()
                ->json(['error' => $th->getMessage()], HttpStatusEnum::INTERNAL_SERVER_ERROR->value);
        }
    }
}