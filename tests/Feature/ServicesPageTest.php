<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceOption;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServicesPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_services_are_grouped_by_category(): void
    {
        $category = ServiceCategory::factory()->create(['name' => 'Vanilles']);
        $service = Service::factory()->create([
            'service_category_id' => $category->id,
            'is_active' => true,
        ]);

        $response = $this->get(route('services.index'));

        $response->assertOk();
        $response->assertSeeInOrder(['Vanilles', $service->name]);
    }

    public function test_services_without_a_category_appear_under_a_fallback_section(): void
    {
        $service = Service::factory()->create([
            'service_category_id' => null,
            'is_active' => true,
        ]);

        $response = $this->get(route('services.index'));

        $response->assertOk();
        $response->assertSee('Autres prestations');
        $response->assertSee($service->name);
    }

    public function test_inactive_categories_and_services_are_hidden(): void
    {
        $hiddenCategory = ServiceCategory::factory()->create(['name' => 'Catégorie masquée', 'is_active' => false]);
        Service::factory()->create(['service_category_id' => $hiddenCategory->id, 'is_active' => true]);

        $visibleCategory = ServiceCategory::factory()->create(['name' => 'Catégorie visible']);
        Service::factory()->create(['service_category_id' => $visibleCategory->id, 'is_active' => false]);

        $response = $this->get(route('services.index'));

        $response->assertOk();
        $response->assertDontSee('Catégorie masquée');
        // The category has no active service left, so it should not render either.
        $response->assertDontSee('Catégorie visible');
    }

    public function test_service_options_are_displayed(): void
    {
        $service = Service::factory()->create(['is_active' => true]);
        ServiceOption::factory()->for($service)->create([
            'group_label' => 'Longueur',
            'value_label' => 'Mi-dos',
            'is_active' => true,
        ]);

        $response = $this->get(route('services.index'));

        $response->assertOk();
        $response->assertSee('Longueur');
        $response->assertSee('Mi-dos');
    }
}
