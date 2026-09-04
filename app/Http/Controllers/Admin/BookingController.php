<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    /**
     * Update the status of a booking.
     */
    public function update(Request $request, Booking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys(Booking::statusLabels()))],
        ]);

        $booking->update($validated);

        return back()->with('success', 'Réservation mise à jour.');
    }

    /**
     * Delete a booking.
     */
    public function destroy(Booking $booking): RedirectResponse
    {
        $booking->delete();

        return back()->with('success', 'Réservation supprimée.');
    }
}
