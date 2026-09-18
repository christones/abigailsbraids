<?php

namespace Tests\Feature;

use App\Models\Training;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTrainingCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $response = $this->get(route('admin.trainings.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_see_trainings(): void
    {
        $user = User::factory()->create();
        $training = Training::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.trainings.index'));

        $response->assertOk();
        $response->assertSee($training->name);
    }

    public function test_authenticated_user_can_create_a_training(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.trainings.store'), [
            'name' => 'Initiation aux tresses',
            'description' => 'Une belle formation.',
            'level' => 'Débutant',
            'duration_minutes' => 360,
            'price_from' => 250,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.trainings.index'));
        $this->assertDatabaseHas('trainings', [
            'name' => 'Initiation aux tresses',
            'slug' => 'initiation-aux-tresses',
        ]);
    }

    public function test_authenticated_user_can_update_a_training(): void
    {
        $user = User::factory()->create();
        $training = Training::factory()->create();

        $response = $this->actingAs($user)->patch(route('admin.trainings.update', $training), [
            'name' => 'Formation avancée',
            'level' => $training->level,
            'duration_minutes' => $training->duration_minutes,
            'price_from' => $training->price_from,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.trainings.index'));
        $this->assertDatabaseHas('trainings', [
            'id' => $training->id,
            'name' => 'Formation avancée',
        ]);
    }

    public function test_authenticated_user_can_reorder_trainings(): void
    {
        $user = User::factory()->create();
        $first = Training::factory()->create(['sort_order' => 0]);
        $second = Training::factory()->create(['sort_order' => 1]);

        $response = $this->actingAs($user)->patch(route('admin.trainings.move-down', $first));

        $response->assertRedirect(route('admin.trainings.index'));
        $this->assertSame(1, $first->refresh()->sort_order);
        $this->assertSame(0, $second->refresh()->sort_order);
    }

    public function test_authenticated_user_can_delete_a_training(): void
    {
        $user = User::factory()->create();
        $training = Training::factory()->create();

        $response = $this->actingAs($user)->delete(route('admin.trainings.destroy', $training));

        $response->assertRedirect(route('admin.trainings.index'));
        $this->assertDatabaseMissing('trainings', ['id' => $training->id]);
    }
}
