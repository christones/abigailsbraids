<?php

namespace Tests\Feature;

use App\Models\GalleryImage;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_displays_active_services(): void
    {
        $service = Service::factory()->create(['is_active' => true]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee($service->name);
    }

    public function test_gallery_page_displays_active_images_from_database(): void
    {
        $visible = GalleryImage::factory()->create(['is_active' => true, 'label' => 'Box braids visibles']);
        $hidden = GalleryImage::factory()->create(['is_active' => false, 'label' => 'Photo masquée']);

        $response = $this->get(route('gallery'));

        $response->assertOk();
        $response->assertSee($visible->label);
        $response->assertDontSee($hidden->label);
    }

    public function test_public_pages_are_reachable(): void
    {
        foreach (['services.index', 'trainings.index', 'gallery', 'products.index', 'about', 'contact'] as $routeName) {
            $this->get(route($routeName))->assertOk();
        }
    }
}
