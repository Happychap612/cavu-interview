<?php

namespace Tests\Feature;

use Tests\TestCase;

class CarParkSpacesTest extends TestCase
{
    public function test_index(): void
    {
        $response = $this->get('/api/v1/car-park/1/spaces');

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
        $response = $this->get('/api/v1/car-park/1/spaces/1');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'name',
        ]);
    }
}
