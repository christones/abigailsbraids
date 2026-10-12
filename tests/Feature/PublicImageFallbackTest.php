<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicImageFallbackTest extends TestCase
{
    use RefreshDatabase;

    public function test_images_missing_from_the_web_root_are_served_from_the_app(): void
    {
        $response = $this->get('/images/categories/coiffure-tresses.jpg');

        $response->assertOk();
        $this->assertStringStartsWith('image/', $response->headers->get('Content-Type'));
    }

    public function test_image_route_refuses_unknown_files_and_path_traversal(): void
    {
        $this->get('/images/categories/nope.jpg')->assertNotFound();
        $this->get('/images/../../.env')->assertNotFound();
        $this->get('/images/..%2F..%2F.env')->assertNotFound();
        $this->get('/uploads/..%2F..%2F.env')->assertNotFound();
    }

    public function test_homepage_promo_lists_the_database_categories(): void
    {
        $withProducts = ProductCategory::factory()->create(['name' => 'Perruques & Toppers', 'slug' => 'perruques-toppers', 'sort_order' => 0, 'image_path' => 'images/categories/perruques-toppers.jpg']);
        Product::factory()->create(['product_category_id' => $withProducts->id, 'is_active' => true]);
        ProductCategory::factory()->create(['name' => 'Maquillage & Beauté', 'slug' => 'maquillage-beaute', 'sort_order' => 1]);
        ProductCategory::factory()->create(['name' => 'Catégorie masquée', 'slug' => 'masquee', 'sort_order' => 2, 'is_active' => false]);

        $response = $this->get(route('home'));

        $response->assertOk()
            ->assertSee('Perruques &amp; Toppers', false)
            ->assertSee('Maquillage &amp; Beauté', false)
            ->assertSee('images/categories/perruques-toppers.jpg')
            ->assertSee(route('products.index', ['categorie' => 'perruques-toppers']), false)
            ->assertDontSee('Catégorie masquée')
            ->assertDontSee('placeholder-huile.svg');
    }

    public function test_uploads_stored_in_the_app_folder_are_served(): void
    {
        $dir = base_path('public/uploads/products');
        @mkdir($dir, 0777, true);
        $file = $dir.'/test-fallback-'.uniqid().'.jpg';
        copy(base_path('public/images/categories/coiffure-tresses.jpg'), $file);

        try {
            $this->get('/uploads/products/'.basename($file))->assertOk();
        } finally {
            @unlink($file);
        }

        $this->get('/uploads/products/missing.jpg')->assertNotFound();
    }
}
