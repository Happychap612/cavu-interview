<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarPark;
use App\Models\CarPark\Space;

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

    /**
     * Return availability for a car park
     *
     * @param CarPark $carPark
     * @param Request $request
     * @return Collection[Space]
     */
    public function availability(CarPark $carPark, Request $request)
    {
        $validated = $request->validate([
            'start' => 'required|date|before:end|after_or_equal:tomorrow',
            'end' => 'required|date|after_or_equal:start',
        ]);

        $spaces = $carPark->spaces()->whereDoesntHave('bookings', function ($query) use ($validated) {
            $query->whereBetween('start', [$validated['start'], $validated['end']])
                ->orWhereBetween('end', [$validated['start'], $validated['end']]);
        })->get();

        return $spaces->makeHidden('car_park_id');
    }
}
