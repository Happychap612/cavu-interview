<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarPark;
use Carbon\Carbon;
// use App\Models\CarPark\Space;

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
     * 
     * @TODO hide spaces car park ID but laravel wasn't playing ball
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
     * @TODO support pricing based on pricing rules stored in the database per car-park e.g. weekends, summer, winter
     * @TODO move validation to a form request
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

        $start = Carbon::parse($validated['start']);
        $end = Carbon::parse($validated['end']);

        $spaces = $carPark->spaces()->whereDoesntHave('bookings', function ($query) use ($start, $end) {
            $query->whereBetween('start', [$start, $end])
                ->orWhereBetween('end', [$start, $end]);
        })->get();

        if ($spaces->isEmpty()) {
            return response()->json([
                'message' => 'No availability for this car park on these dates',
            ], 400);
        }

        // create range after validation to ensure the dates are valid we're not calcing prices when theres no availability
        $dates = $start->range($end, '1 day');
        $price = 0;

        foreach ($dates as $date) {
            $price += $date->isWeekend() ? $carPark->weekendRate : $carPark->weekdayRate;
            $price += ($date->quarter == 2 or $date->quarter == 3) ? $carPark->summerRate : $carPark->winterRate;
        }

        return response()->json([
            'spaces' => $spaces->makeHidden('car_park_id'),
            'price' => $price,          
        ]);
    }
}
