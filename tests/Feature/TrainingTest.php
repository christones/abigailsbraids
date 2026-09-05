<?php

namespace Tests\Feature;

use App\Models\Training;
use App\Models\TrainingRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrainingTest extends TestCase
{
    use RefreshDatabase;

    public function test_trainings_page_lists_active_trainings(): void
    {
        $training = Training::factory()->create(['is_active' => true]);
        Training::factory()->create(['is_active' => false]);

        $response = $this->get(route('trainings.index'));

        $response->assertOk();
        $response->assertSee($training->name);
    }

    public function test_registration_page_lists_active_trainings(): void
    {
        $training = Training::factory()->create(['is_active' => true]);

        $response = $this->get(route('training.create'));

        $response->assertOk();
        $response->assertSee($training->name);
    }

    public function test_a_candidate_can_submit_a_training_registration(): void
    {
        $training = Training::factory()->create();

        $payload = [
            'training_id' => $training->id,
            'candidate_name' => 'Fatoumata Diallo',
            'candidate_email' => 'fatou@example.com',
            'candidate_phone' => '0600000000',
            'preferred_date' => now()->addWeek()->toDateString(),
            'experience_level' => 'Débutante',
            'message' => 'Je souhaite apprendre les box braids.',
        ];

        $response = $this->post(route('training.store'), $payload);

        $this->assertDatabaseHas('training_registrations', [
            'candidate_email' => 'fatou@example.com',
            'training_id' => $training->id,
            'status' => TrainingRegistration::STATUS_PENDING,
        ]);

        $registration = TrainingRegistration::firstWhere('candidate_email', 'fatou@example.com');

        $response->assertRedirect(route('training.confirmation', $registration));
    }

    public function test_registration_requires_a_valid_training_and_date(): void
    {
        $response = $this->post(route('training.store'), [
            'candidate_name' => 'Sans formation',
            'candidate_email' => 'invalid-email',
            'candidate_phone' => '0600000000',
            'preferred_date' => now()->toDateString(), // today is not allowed
        ]);

        $response->assertSessionHasErrors([
            'training_id',
            'candidate_email',
            'preferred_date',
        ]);

        $this->assertDatabaseCount('training_registrations', 0);
    }

    public function test_confirmation_page_shows_registration_summary(): void
    {
        $training = Training::factory()->create();
        $registration = TrainingRegistration::factory()->for($training)->create();

        $response = $this->get(route('training.confirmation', $registration));

        $response->assertOk();
        $response->assertSee($registration->candidate_name);
        $response->assertSee($training->name);
    }
}
