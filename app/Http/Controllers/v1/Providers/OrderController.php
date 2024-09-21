<?php

namespace App\Http\Controllers\v1\Providers;

use Inertia\Inertia;
use App\Enums\HttpStatusEnum;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\v1\Providers\OrderService;
use App\Http\Requests\v1\Providers\CreateOrderRequest;

class OrderController extends Controller
{
    /**
     * Get Create Orders View Page
     * 
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('SubmitOrder');
    }

    /**
     * Create Order From Api
     * 
     * @return JsonResponse
     */
    public function create(CreateOrderRequest $request): JsonResponse
    {
        try {

            $provider = $request->provider;
            $hmo_code = $request->hmo_code;
            $encounter_date = $request->encounter_date;
            $total_items_cost = $request->total_items_cost;
            $items = $request->items;

            $result = (new OrderService())->Create(
                $hmo_code = (string) $hmo_code,
                $provider = (string) $provider,
                $encounter_date = (string) $encounter_date,
                $total_items_cost = (float) $total_items_cost,
                $items = $items
            );

            return response()->json([]);
        } catch (\Throwable $th) {

            return response()
                ->json(['error' => $th->getMessage()], HttpStatusEnum::INTERNAL_SERVER_ERROR->value);
        }
    }
}
