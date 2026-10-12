<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCategoryDisplayTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Create a category holding one active product.
     */
    private function categoryWithProduct(array $attributes = []): ProductCategory
    {
        $category = ProductCategory::factory()->create($attributes);
        Product::factory()->create(['product_category_id' => $category->id, 'is_active' => true]);

        return $category;
    }

    public function test_homepage_hides_the_section_when_there_is_no_category_with_products(): void
    {
        ProductCategory::factory()->create(['name' => 'Catégorie vide']);

        $response = $this->get(route('home'))->assertOk();

        $this->assertStringNotContainsString('Choisissez une catégorie pour découvrir les produits', $response->getContent());
        $response->assertDontSee('Voir toutes les catégories');
    }

    public function test_homepage_shows_the_first_four_categories_linking_to_the_shop(): void
    {
        $categories = collect(range(0, 3))->map(fn ($i) => $this->categoryWithProduct([
            'name' => "Catégorie {$i}",
            'slug' => "categorie-{$i}",
            'sort_order' => $i,
        ]));

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSeeInOrder(['Nos prestations', 'Catégorie 0', 'Catégorie 3', 'Galerie']);
        foreach ($categories as $category) {
            $response->assertSee(route('products.index', ['categorie' => $category->slug]), false);
        }
        $response->assertDontSee('Voir toutes les catégories');
    }

    public function test_homepage_shows_a_button_when_more_than_four_categories_exist(): void
    {
        foreach (range(0, 4) as $i) {
            $this->categoryWithProduct(['name' => "Catégorie {$i}", 'slug' => "categorie-{$i}", 'sort_order' => $i]);
        }

        $response = $this->get(route('home'));

        $section = $this->categoriesSection($response->getContent());
        $this->assertStringContainsString('Catégorie 3', $section);
        $this->assertStringNotContainsString('Catégorie 4', $section);
        $response->assertSee('Voir toutes les catégories');
        $response->assertSee(route('products.categories'), false);
    }

    public function test_hidden_or_empty_categories_are_not_counted(): void
    {
        foreach (range(0, 3) as $i) {
            $this->categoryWithProduct(['sort_order' => $i]);
        }
        $this->categoryWithProduct(['is_active' => false, 'name' => 'Masquée']);
        ProductCategory::factory()->create(['name' => 'Sans produit']);
        $onlyInactive = ProductCategory::factory()->create(['name' => 'Produits masqués']);
        Product::factory()->create(['product_category_id' => $onlyInactive->id, 'is_active' => false]);

        $this->get(route('home'))->assertDontSee('Voir toutes les catégories');
        $this->get(route('products.categories'))
            ->assertOk()
            ->assertDontSee('Masquée')
            ->assertDontSee('Sans produit')
            ->assertDontSee('Produits masqués');
    }

    public function test_categories_page_lists_every_visible_category(): void
    {
        foreach (range(0, 5) as $i) {
            $this->categoryWithProduct(['name' => "Catégorie {$i}", 'slug' => "categorie-{$i}", 'sort_order' => $i]);
        }

        $this->get(route('products.categories'))
            ->assertOk()
            ->assertSeeInOrder(['Catégorie 0', 'Catégorie 5']);
    }

    public function test_shop_can_be_filtered_by_category(): void
    {
        $oils = ProductCategory::factory()->create(['name' => 'Huiles', 'slug' => 'huiles']);
        $accessories = ProductCategory::factory()->create(['name' => 'Accessoires', 'slug' => 'accessoires']);
        $oil = Product::factory()->create(['name' => 'Huile de coco', 'product_category_id' => $oils->id]);
        $bonnet = Product::factory()->create(['name' => 'Bonnet en satin', 'product_category_id' => $accessories->id]);

        $this->get(route('products.index', ['categorie' => 'huiles']))
            ->assertOk()
            ->assertSee($oil->name)
            ->assertDontSee($bonnet->name);

        $this->get(route('products.index'))
            ->assertOk()
            ->assertSee($oil->name)
            ->assertSee($bonnet->name);
    }

    public function test_unknown_category_returns_404(): void
    {
        $this->get(route('products.index', ['categorie' => 'inexistante']))->assertNotFound();
    }

    public function test_hero_slider_promotes_trainings_and_shop(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Apprenez l&#039;art du tressage', false)
            ->assertSee(route('trainings.index'), false)
            ->assertSee('Vos produits capillaires')
            ->assertSee('Visiter la boutique');
    }

    /**
     * The HTML of the homepage "categories" section only (the promo banner
     * further up also lists every category as a shortcut).
     */
    private function categoriesSection(string $html): string
    {
        $start = strpos($html, 'Choisissez une catégorie pour découvrir les produits');
        $end = strpos($html, 'Nos dernières réalisations', (int) $start);

        $this->assertNotFalse($start);

        return substr($html, $start, $end - $start);
    }
}
