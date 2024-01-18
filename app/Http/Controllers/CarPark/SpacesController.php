<?php

namespace App\Http\Controllers\CarPark;

use App\Http\Controllers\Controller;
use App\Models\CarPark;
use App\Models\CarPark\Space;

/**
 * car park spaces within the context of their parent car park,
 * hence why all of these require the car park to be provided
 */
class SpacesController extends Controller
{
    /**
     * Car park spaces index, requires the car park to be provided
     *
     * @param CarPark $carPark
     * @return Collection[Space]
     */
    public function index(CarPark $carPark)
    {
        return $carPark->spaces->makeHidden('car_park_id');
    }

    /**
     * Show a specific car park spaces info, requires the car park to be provided
     * if the space does not belong to the car park, a 404 is returned
     *
     * @param CarPark $carPark
     * @param Space $space
     * @return Space|HTTPException
     */
    public function show(CarPark $carPark, Space $space)
    {
        if ($space->car_park_id !== $carPark->id) {
            abort(404);
        }
        return $space;
    }
}
