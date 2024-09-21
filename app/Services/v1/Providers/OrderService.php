<?php

declare(strict_types=1);

namespace App\Services\v1\Providers;

use App\Enums\BatchRuleEnum;
use App\Models\Batch;
use App\Models\BatchOrder;
use App\Models\Order;
use App\Models\OrderItem;
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

            // Create Order
            $order = Order::create([
                'hmo_code' => $hmo_code,
                'provider' => $provider,
                'encounter_date' => $encounter_date,
                'total_items_cost' => $total_items_cost,
            ]);

            // Create Order Items
            $this->CreateOrderItems($order->id, $items);

            $order = $order->load('hmo');

            // Create the Batch
            $batch = $this->FindOrCreateBatch($order);

            // Create Batch and Order Relationship
            $this->CreateBatchOrder($order, $batch);

            // Notify HMO (Send Email)

            DB::commit();
            //code...
        } catch (\Throwable $th) {

            DB::rollBack();
            //throw $th;
        }
    }

    /**
     * Create Order Items and returns their ids
     * 
     * @param int $order_id
     * @param array<array{
     *     name: string,
     *     quantity: int,
     *     sub_total: float,
     *     unit_price: float|int
     * }> $items
     * 
     * @return bool
     * 
     * @throws \Throwable
     */
    private function CreateOrderItems(int $order_id, array $items): bool
    {
        try {

            (int) $chunk_size = 50;

            collect($items)->chunk($chunk_size)->each(function ($chunkedItems) use ($order_id) {
                foreach ($chunkedItems as $item) {
                    OrderItem::create([
                        'order_id'   => $order_id,
                        'name'       => $item['name'],
                        'quantity'   => $item['quantity'],
                        'sub_total'  => $item['sub_total'],
                        'unit_price' => $item['unit_price'],
                    ]);
                }
            });

            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Find or create a batch for the given order.
     * 
     * This method first attempts to find an existing batch by the generated identifier.
     * If a batch with that identifier does not exist, it creates a new batch with the provided order and HMO details.
     * 
     * @param mixed $order The order object, containing information such as HMO, order ID, and batch rule.
     * 
     * @return mixed The found or newly created Batch model instance.
     * 
     * @throws \Throwable If any error occurs during the batch lookup or creation process.
     */
    private function FindOrCreateBatch(mixed $order): mixed
    {
        try {

            // Load HMO attched to this order
            $hmo = $order->load('hmo')->hmo;

            // Generate Batch Name
            $identifier = $this->GenerateBatchIdentifier($order, $hmo);

            $batch = (Batch::where('identifier', $identifier)->exists())
                ? Batch::where('identifier', $identifier)->first()
                : Batch::create([
                    'identifier' => $identifier,
                    'hmo_id' => $hmo->id,
                    'order_id' => $order->id,
                    'batch_rule' => $hmo->batch_rule,
                ]);

            return $batch;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Generate a batch identifier for the given order.
     * 
     * This method generates a batch identifier based on the HMO's batch rule.
     * If the HMO's batch rule is `SUBMISSION_DATE`, it uses the `encounter_date` of the order.
     * Otherwise, it uses the `created_at` date of the order.
     * 
     * @param mixed $order The order object containing details such as provider, encounter_date, and created_at.
     * 
     * @param mixed $hmo The hmo object containing details such as name, code, email, and batch_rule.
     * 
     * @return string The generated batch identifier, which consists of the provider name, 
     *                the short month name (e.g., "Jan"), and the year.
     * 
     * @throws \Throwable If any error occurs during the batch identifier generation process.
     */
    private function GenerateBatchIdentifier(mixed $order, mixed $hmo): string
    {
        try {

            // Generate Batch Name For HMOs with submission_date batch rule
            if ($hmo->batch_rule->value === BatchRuleEnum::SUBMISSION_DATE->value) {

                $encounter_date = \Carbon\Carbon::parse($order->encounter_date);

                $short_month = $encounter_date->format('M');

                $year = $encounter_date->format('Y');

                return "{$order->provider} {$short_month} {$year}";
            } else {

                $created_date = \Carbon\Carbon::parse($order->created_at);

                $short_month = $created_date->format('M');

                $year = $created_date->format('Y');

                return "{$order->provider} {$short_month} {$year}";
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Create a BatchOrder record linking the given order and batch.
     * 
     * This method creates a new record in the `BatchOrder` table using the IDs of the provided batch and order.
     * 
     * @param mixed $order The order object, containing the order details such as its ID.
     * @param mixed $batch The batch object, containing the batch details such as its ID.
     * 
     * @return mixed The newly created BatchOrder model instance.
     * 
     * @throws \Throwable If any error occurs during the BatchOrder creation process.
     */
    private function CreateBatchOrder(mixed $order, mixed $batch): mixed
    {
        try {

            $res = BatchOrder::create([
                'batch_id' => $batch->id,
                'order_id' => $order->id,
            ]);

            return $res;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
