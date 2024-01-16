<?php

namespace App\Http\Controllers;

use App\Models\CarPark;

class CarParkController extends Controller
{
    public function index()
    {
        return CarPark::all();
    }

    public function show(CarPark $carPark)
    {
        return $carPark->with('spaces')->get();
    }
}
