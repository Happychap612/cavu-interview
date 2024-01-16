<?php

namespace App\Http\Controllers;

use App\Models\CarPark;

class CarParkController extends Controller
{
    /**
     * Car park index action, returns all car parks
     * Should be paginated in a real world scenario
     *
     * @return array[CarPark]
     */
    public function index()
    {
        return CarPark::all();
    }

    /**
     * returns a single car park with all its spaces
     * ideally would hide the spaces car park ID but laravel wasn't playing ball
     *
     * @param CarPark $carPark
     * @return Car Park
     */
    public function show(CarPark $carPark)
    {
        return $carPark->with('spaces')->get()->makeHidden('id');
    }
}
