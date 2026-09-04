<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index(): View
    {
        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('home', [
            'services' => $services,
        ]);
    }
}
