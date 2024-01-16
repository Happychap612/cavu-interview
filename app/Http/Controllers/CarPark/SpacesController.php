<?php

namespace App\Http\Controllers\CarPark;

use App\Http\Controllers\Controller;
use App\Models\CarPark;
use App\Models\CarPark\Space;

class SpacesController extends Controller
{
    public function index(CarPark $carPark)
    {
        return $carPark->spaces->makeHidden('car_park_id');
    }

    public function show(CarPark $carPark, Space $space)
    {
        if ($space->car_park_id !== $carPark->id) {
            abort(404);
        }
        return $space;
    }
}
