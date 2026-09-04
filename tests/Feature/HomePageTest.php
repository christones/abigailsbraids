<?php

namespace Tests\Feature;

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

    public function test_public_pages_are_reachable(): void
    {
        foreach (['services.index', 'gallery', 'about', 'contact'] as $routeName) {
            $this->get(route($routeName))->assertOk();
        }
    }
}
