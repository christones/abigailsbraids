<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\View\View;

class TrainingController extends Controller
{
    /**
     * Show the trainings page.
     */
    public function index(): View
    {
        $trainings = Training::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('trainings.index', [
            'trainings' => $trainings,
        ]);
    }
}
