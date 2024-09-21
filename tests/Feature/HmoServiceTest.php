<?php

namespace Tests\Feature;

use App\Models\Hmo;
use Tests\TestCase;
use Database\Seeders\HmoSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HmoServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Seed the database with HMO data before the test
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(HmoSeeder::class);
    }

    /**
     * Test fetching HMO suggestions based on search query
     *
     * @return void
     */
    public function test_it_can_fetch_hmo_suggestions()
    {

        $searchQuery = Hmo::first()->code;

        $response = $this->get('/api/v1/hmo/suggestions?search=' . $searchQuery);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'result' => [
                    '*' => [
                        'id',
                        'code',
                    ],
                ],
            ]);

        $response->assertJsonFragment([
            'code' => $searchQuery,
        ]);
    }
}
