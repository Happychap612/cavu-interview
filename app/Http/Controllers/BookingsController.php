<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    /**
     * Returns booking without the ID
     *
     * @param Booking $booking
     * @return Booking
     */
    function show(Booking $booking)
    {
        return $booking->makeHidden('id');
    }

    /**
     * Create a booking, currently using in controller validation because this is the only place it is used
     * Could make an argument for using it for the update validation too however that request is only
     * going to be updating the start and end times
     * 
     * @TODO maybe move this to a form request
     * @TODO investigate moving the date range checks inside the validation rules
     *
     * @param Request $request
     * @return Booking
     */
    function store(Request $request)
    {
        $validated = $request->validate([
            'car_park_space_id' => 'required|exists:car_park_spaces,id',
            'customer_id' => 'required|exists:customers,id',
            'start' => 'required|date|before:end|after_or_equal:tomorrow',
            'end' => 'required|date|after_or_equal:start',
        ]);

        $existingBooking = Booking::where('car_park_space_id', $validated['car_park_space_id'])
            ->where('start', '<=', $validated['start'])
            ->where('end', '>=', $validated['end'])
            ->first();

        if ($existingBooking) {
            return response()->json([
                'message' => 'Booking already exists for this space at this time',
            ], 400);
        }

        $booking = Booking::create($validated);

        // No need to hide the ID here as this is a new booking
        return $booking;
    }

    /**
     * Amends a booking
     *
     * @param Booking $booking
     * @return bool
     */
    function update(Booking $booking)
    {
        return $booking->makeHidden('id');
    }

    /**
     * Cancels/Deletes a booking
     *
     * @param Booking $booking
     * @return bool
     */
    function delete(Booking $booking)
    {
        return $booking->delete() ? response()->json([], 204) : response()->json([], 500);
    }
}
