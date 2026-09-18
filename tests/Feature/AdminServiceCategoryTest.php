<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminServiceCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $response = $this->get(route('admin.service-categories.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_see_categories(): void
    {
        $user = User::factory()->create();
        $category = ServiceCategory::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.service-categories.index'));

        $response->assertOk();
        $response->assertSee($category->name);
    }

    public function test_authenticated_user_can_create_a_category(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.service-categories.store'), [
            'name' => 'Tresses collées',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.service-categories.index'));
        $this->assertDatabaseHas('service_categories', [
            'name' => 'Tresses collées',
            'slug' => 'tresses-collees',
        ]);
    }

    public function test_authenticated_user_can_reorder_categories(): void
    {
        $user = User::factory()->create();
        $first = ServiceCategory::factory()->create(['sort_order' => 0]);
        $second = ServiceCategory::factory()->create(['sort_order' => 1]);

        $response = $this->actingAs($user)->patch(route('admin.service-categories.move-down', $first));

        $response->assertRedirect(route('admin.service-categories.index'));
        $this->assertSame(1, $first->refresh()->sort_order);
        $this->assertSame(0, $second->refresh()->sort_order);
    }

    public function test_authenticated_user_can_update_a_category(): void
    {
        $user = User::factory()->create();
        $category = ServiceCategory::factory()->create();

        $response = $this->actingAs($user)->patch(route('admin.service-categories.update', $category), [
            'name' => 'Nouveau nom',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.service-categories.index'));
        $this->assertDatabaseHas('service_categories', [
            'id' => $category->id,
            'name' => 'Nouveau nom',
        ]);
    }

    public function test_deleting_a_category_keeps_its_services_uncategorized(): void
    {
        $user = User::factory()->create();
        $category = ServiceCategory::factory()->create();
        $service = Service::factory()->create(['service_category_id' => $category->id]);

        $response = $this->actingAs($user)->delete(route('admin.service-categories.destroy', $category));

        $response->assertRedirect(route('admin.service-categories.index'));
        $this->assertDatabaseMissing('service_categories', ['id' => $category->id]);
        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'service_category_id' => null,
        ]);
    }
}
