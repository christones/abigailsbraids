<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrainingRegistrationRequest;
use App\Models\Training;
use App\Models\TrainingRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TrainingRegistrationController extends Controller
{
    /**
     * Show the training registration form.
     */
    public function create(): View
    {
        $trainings = Training::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('trainings.registration.create', [
            'trainings' => $trainings,
            'selectedTrainingId' => request()->integer('formation') ?: null,
        ]);
    }

    /**
     * Store a new training registration.
     */
    public function store(StoreTrainingRegistrationRequest $request): RedirectResponse
    {
        $registration = TrainingRegistration::create($request->validated());

        return redirect()
            ->route('training.confirmation', $registration)
            ->with('success', true);
    }

    /**
     * Show the confirmation page for a training registration.
     */
    public function confirmation(TrainingRegistration $trainingRegistration): View
    {
        $trainingRegistration->load('training');

        return view('trainings.registration.confirmation', [
            'registration' => $trainingRegistration,
        ]);
    }
}
