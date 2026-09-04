<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the bookings dashboard.
     */
    public function index(Request $request): View
    {
        $status = $request->string('statut')->toString();

        $bookings = Booking::query()
            ->with('service')
            ->when($status, fn ($query) => $query->where('status', $status))
            ->orderBy('preferred_date')
            ->orderBy('preferred_time')
            ->paginate(15)
            ->withQueryString();

        return view('admin.dashboard', [
            'bookings' => $bookings,
            'status' => $status,
            'counts' => [
                'pending' => Booking::where('status', Booking::STATUS_PENDING)->count(),
                'confirmed' => Booking::where('status', Booking::STATUS_CONFIRMED)->count(),
                'total' => Booking::count(),
            ],
        ]);
    }
}
