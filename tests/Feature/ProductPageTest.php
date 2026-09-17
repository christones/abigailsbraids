<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_boutique_page_lists_active_products(): void
    {
        $visible = Product::factory()->create(['is_active' => true]);
        $hidden = Product::factory()->create(['is_active' => false]);

        $response = $this->get(route('products.index'));

        $response->assertOk();
        $response->assertSee($visible->name);
        $response->assertDontSee($hidden->name);
    }
}
