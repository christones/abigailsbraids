<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $response = $this->get(route('admin.services.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_see_services(): void
    {
        $user = User::factory()->create();
        $service = Service::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.services.index'));

        $response->assertOk();
        $response->assertSee($service->name);
    }

    public function test_authenticated_user_can_create_a_service(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.services.store'), [
            'name' => 'Tresses collées',
            'description' => 'Une belle prestation.',
            'duration_minutes' => 120,
            'price_from' => 80,
            'sort_order' => 1,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.services.index'));
        $this->assertDatabaseHas('services', [
            'name' => 'Tresses collées',
            'slug' => 'tresses-collees',
        ]);
    }

    public function test_authenticated_user_can_upload_a_service_image(): void
    {
        $user = User::factory()->create();
        $service = Service::factory()->create();

        $response = $this->actingAs($user)->patch(route('admin.services.update', $service), [
            'name' => $service->name,
            'duration_minutes' => $service->duration_minutes,
            'price_from' => $service->price_from,
            'image' => UploadedFile::fake()->create('service.jpg', 100, 'image/jpeg'),
        ]);

        $response->assertRedirect(route('admin.services.index'));
        $service->refresh();
        $this->assertNotNull($service->image_path);
    }

    public function test_authenticated_user_can_delete_a_service(): void
    {
        $user = User::factory()->create();
        $service = Service::factory()->create();

        $response = $this->actingAs($user)->delete(route('admin.services.destroy', $service));

        $response->assertRedirect(route('admin.services.index'));
        $this->assertDatabaseMissing('services', ['id' => $service->id]);
    }
}
