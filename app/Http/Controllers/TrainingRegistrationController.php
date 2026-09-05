<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrainingRegistrationRequest;
use App\Mail\NewTrainingRegistrationNotification;
use App\Mail\TrainingRegistrationConfirmation;
use App\Models\Training;
use App\Models\TrainingRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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

        $this->sendNotifications($registration);

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

    /**
     * Email the salon and the candidate about the new registration.
     */
    private function sendNotifications(TrainingRegistration $registration): void
    {
        try {
            Mail::to(config('salon.notification_email'))
                ->send(new NewTrainingRegistrationNotification($registration));
        } catch (\Throwable $e) {
            Log::error('Failed to send new training registration notification email.', [
                'registration_id' => $registration->id,
                'error' => $e->getMessage(),
            ]);
        }

        try {
            Mail::to($registration->candidate_email)
                ->send(new TrainingRegistrationConfirmation($registration));
        } catch (\Throwable $e) {
            Log::error('Failed to send training registration confirmation email to candidate.', [
                'registration_id' => $registration->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
