<?php

namespace Tests\Feature;

use App\Models\Hmo;
use Tests\TestCase;
use Faker\Factory as Faker;
use App\Enums\BatchRuleEnum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Create order test via API
     *
     * @return void
     */
    public function test_it_can_create_an_order()
    {
        $faker = Faker::create();

        $batch_rules = BatchRuleEnum::getAll();

        $random_index = array_rand($batch_rules);

        $hmo = Hmo::create(['code' => $faker->word, 'name' => 'HMO B', 'email' => $faker->email,  'batch_rule' => $batch_rules[$random_index]]);

        $payload = [
            'provider' => $faker->word,
            'hmo_code' => $hmo->code,
            'encounter_date' => '2024-09-14',
            'total_items_cost' => 1000.00,
            'items' => [
                [
                    'name' => "Item-{$faker->word}",
                    'unit_price' => 1000,
                    'quantity' => 1,
                    'sub_total' => 1000.00
                ]
            ]
        ];

        $response = $this->json('POST', '/api/v1/order', $payload);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'result' => [
                    'hmo_code',
                    'provider',
                    'encounter_date',
                    'total_items_cost',
                    'updated_at',
                    'created_at',
                    'id',
                    'hmo' => [
                        'id',
                        'name',
                        'code',
                        'email',
                        'batch_rule',
                    ]
                ]
            ]);
    }
}
