<?php

namespace Tests\Feature;

use App\Models\Training;
use App\Models\TrainingRegistration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTrainingTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $response = $this->get(route('admin.trainings.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_see_training_registrations(): void
    {
        $user = User::factory()->create();
        $training = Training::factory()->create();
        $registration = TrainingRegistration::factory()->for($training)->create();

        $response = $this->actingAs($user)->get(route('admin.trainings.index'));

        $response->assertOk();
        $response->assertSee($registration->candidate_name);
    }

    public function test_authenticated_user_can_update_registration_status(): void
    {
        $user = User::factory()->create();
        $training = Training::factory()->create();
        $registration = TrainingRegistration::factory()->for($training)->create(['status' => TrainingRegistration::STATUS_PENDING]);

        $response = $this->actingAs($user)->patch(route('admin.trainings.update', $registration), [
            'status' => TrainingRegistration::STATUS_CONFIRMED,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('training_registrations', [
            'id' => $registration->id,
            'status' => TrainingRegistration::STATUS_CONFIRMED,
        ]);
    }

    public function test_authenticated_user_can_delete_a_registration(): void
    {
        $user = User::factory()->create();
        $training = Training::factory()->create();
        $registration = TrainingRegistration::factory()->for($training)->create();

        $response = $this->actingAs($user)->delete(route('admin.trainings.destroy', $registration));

        $response->assertRedirect();
        $this->assertDatabaseMissing('training_registrations', ['id' => $registration->id]);
    }
}
