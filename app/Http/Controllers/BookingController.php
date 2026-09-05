<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Mail\NewBookingNotification;
use App\Models\Booking;
use App\Models\Service;
use App\Support\BookingSlots;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Show the booking form.
     */
    public function create(): View
    {
        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('booking.create', [
            'services' => $services,
            'slots' => BookingSlots::all(),
            'selectedServiceId' => request()->integer('prestation') ?: null,
        ]);
    }

    /**
     * Store a new booking request.
     */
    public function store(StoreBookingRequest $request): \Illuminate\Http\RedirectResponse
    {
        $booking = Booking::create($request->validated());

        try {
            Mail::to(config('salon.notification_email'))
                ->send(new NewBookingNotification($booking));
        } catch (\Throwable $e) {
            Log::error('Failed to send new booking notification email.', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
            ]);
        }

        return redirect()
            ->route('booking.confirmation', $booking)
            ->with('success', true);
    }

    /**
     * Show the confirmation page for a booking.
     */
    public function confirmation(Booking $booking): View
    {
        $booking->load('service');

        return view('booking.confirmation', [
            'booking' => $booking,
        ]);
    }
}
