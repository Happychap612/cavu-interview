<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingSaveRequest;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    private function existingBooking($carParkSpaceId, $start, $end, $bookingId = null)
    {
        return Booking::where('car_park_space_id', $carParkSpaceId)
            ->where('start', '<=', $start)
            ->where('end', '>=', $end)
            ->where('id', '!=', $bookingId)
            ->first();
    }

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
     * @TODO investigate moving the date range checks inside the validation rules
     *
     * @param Request $request
     * @return Booking
     */
    function store(BookingSaveRequest $request)
    {
        $validated = $request->validated();
        $existingBooking = $this->existingBooking($validated['car_park_space_id'], $validated['start'], $validated['end']);

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
    function update(Booking $booking, BookingSaveRequest $request)
    {
        $validated = $request->validated();
        $existingBooking = $this->existingBooking($validated['car_park_space_id'], $validated['start'], $validated['end'], $booking->id);

        if ($existingBooking) {
            return response()->json([
                'message' => 'Cannot amend booking as there is already a booking for this space at this time',
            ], 400);
        }

        $booking->update($validated);

        // No need to hide the ID here as this is a new booking
        return $booking;
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
