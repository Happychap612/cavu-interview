<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;

class CarParkTest extends TestCase
{
    public function test_index(): void
    {
        $response = $this->get('/api/v1/car-park');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
            ],
        ]);
    }

    public function test_show(): void
    {
        $response = $this->get('/api/v1/car-park/1');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            [
                'name',
                'spaces' => [
                    '*' => [
                        'id',
                        'car_park_id',
                        'name',
                    ],
                ],
            ],
        ]);
    }

    public function test_availability_no_date_provided(): void
    {
        $response = $this->post('/api/v1/car-park/1/availability');

        $response->assertStatus(302);
    }

    public function test_availability_too_early_date_provided(): void
    {
        $response = $this->post('/api/v1/car-park/1/availability', [
            'start' => '2021-01-01',
            'end' => '2021-01-02',
        ]);

        $response->assertStatus(302);
    }

    public function test_availability_date_provided(): void
    {
        $response = $this->post('/api/v1/car-park/1/availability', [
            'start' => Carbon::now()->addDays(1)->toDateString(),
            'end' => Carbon::now()->addDays(2)->toDateString(),
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'price',
            'spaces' => [
                '*' => [
                    'id',
                    'name',
                ],
            ],
        ]);
    }
}
