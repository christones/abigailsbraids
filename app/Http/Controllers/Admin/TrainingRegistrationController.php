<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainingRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class TrainingRegistrationController extends Controller
{
    /**
     * Display the training registrations dashboard.
     */
    public function index(Request $request): View
    {
        $status = $request->string('statut')->toString();

        $registrations = TrainingRegistration::query()
            ->with('training')
            ->when($status, fn ($query) => $query->where('status', $status))
            ->orderBy('preferred_date')
            ->paginate(15)
            ->withQueryString();

        return view('admin.trainings', [
            'registrations' => $registrations,
            'status' => $status,
            'counts' => [
                'pending' => TrainingRegistration::where('status', TrainingRegistration::STATUS_PENDING)->count(),
                'confirmed' => TrainingRegistration::where('status', TrainingRegistration::STATUS_CONFIRMED)->count(),
                'total' => TrainingRegistration::count(),
            ],
        ]);
    }

    /**
     * Update the status of a training registration.
     */
    public function update(Request $request, TrainingRegistration $trainingRegistration): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys(TrainingRegistration::statusLabels()))],
        ]);

        $trainingRegistration->update($validated);

        return back()->with('success', 'Inscription mise à jour.');
    }

    /**
     * Delete a training registration.
     */
    public function destroy(TrainingRegistration $trainingRegistration): RedirectResponse
    {
        $trainingRegistration->delete();

        return back()->with('success', 'Inscription supprimée.');
    }
}
