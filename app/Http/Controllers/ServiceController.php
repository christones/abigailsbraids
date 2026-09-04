<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Display all of the salon's services.
     */
    public function index(): View
    {
        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('services', [
            'services' => $services,
        ]);
    }
}
