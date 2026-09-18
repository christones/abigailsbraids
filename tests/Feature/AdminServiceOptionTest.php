<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\ServiceOption;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminServiceOptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $service = Service::factory()->create();

        $response = $this->get(route('admin.services.options.index', $service));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_see_options_for_a_service(): void
    {
        $user = User::factory()->create();
        $service = Service::factory()->create();
        $option = ServiceOption::factory()->for($service)->create();

        $response = $this->actingAs($user)->get(route('admin.services.options.index', $service));

        $response->assertOk();
        $response->assertSee($option->value_label);
    }

    public function test_authenticated_user_can_add_an_option(): void
    {
        $user = User::factory()->create();
        $service = Service::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.services.options.store', $service), [
            'group_label' => 'Longueur',
            'value_label' => 'Mi-dos',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.services.options.index', $service));
        $this->assertDatabaseHas('service_options', [
            'service_id' => $service->id,
            'group_label' => 'Longueur',
            'value_label' => 'Mi-dos',
        ]);
    }

    public function test_authenticated_user_can_reorder_options_within_their_group(): void
    {
        $user = User::factory()->create();
        $service = Service::factory()->create();
        $first = ServiceOption::factory()->for($service)->create(['group_label' => 'Couleur', 'sort_order' => 0]);
        $second = ServiceOption::factory()->for($service)->create(['group_label' => 'Couleur', 'sort_order' => 1]);
        $otherGroup = ServiceOption::factory()->for($service)->create(['group_label' => 'Modèle', 'sort_order' => 2]);

        $response = $this->actingAs($user)->patch(route('admin.services.options.move-up', [$service, $second]));

        $response->assertRedirect(route('admin.services.options.index', $service));
        $this->assertSame(0, $second->refresh()->sort_order);
        $this->assertSame(1, $first->refresh()->sort_order);
        $this->assertSame(2, $otherGroup->refresh()->sort_order);
    }

    public function test_authenticated_user_can_update_an_option(): void
    {
        $user = User::factory()->create();
        $service = Service::factory()->create();
        $option = ServiceOption::factory()->for($service)->create();

        $response = $this->actingAs($user)->patch(route('admin.services.options.update', [$service, $option]), [
            'group_label' => 'Couleur',
            'value_label' => 'Auburn',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.services.options.index', $service));
        $this->assertDatabaseHas('service_options', [
            'id' => $option->id,
            'group_label' => 'Couleur',
            'value_label' => 'Auburn',
        ]);
    }

    public function test_authenticated_user_can_delete_an_option(): void
    {
        $user = User::factory()->create();
        $service = Service::factory()->create();
        $option = ServiceOption::factory()->for($service)->create();

        $response = $this->actingAs($user)->delete(route('admin.services.options.destroy', [$service, $option]));

        $response->assertRedirect(route('admin.services.options.index', $service));
        $this->assertDatabaseMissing('service_options', ['id' => $option->id]);
    }

    public function test_deleting_a_service_deletes_its_options(): void
    {
        $service = Service::factory()->create();
        $option = ServiceOption::factory()->for($service)->create();

        $service->delete();

        $this->assertDatabaseMissing('service_options', ['id' => $option->id]);
    }
}
