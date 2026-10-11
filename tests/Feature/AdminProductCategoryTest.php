<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProductCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get(route('admin.product-categories.index'))->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_see_categories(): void
    {
        $user = User::factory()->create();
        $category = ProductCategory::factory()->create();

        $this->actingAs($user)->get(route('admin.product-categories.index'))
            ->assertOk()
            ->assertSee($category->name);
    }

    public function test_create_and_edit_forms_render(): void
    {
        $user = User::factory()->create();
        $category = ProductCategory::factory()->create();

        $this->actingAs($user)->get(route('admin.product-categories.create'))->assertOk();
        $this->actingAs($user)->get(route('admin.product-categories.edit', $category))->assertOk()->assertSee($category->name);
    }

    public function test_authenticated_user_can_create_a_category_placed_last(): void
    {
        $user = User::factory()->create();
        ProductCategory::factory()->create(['sort_order' => 5]);

        $response = $this->actingAs($user)->post(route('admin.product-categories.store'), [
            'name' => 'Soins & huiles',
            'description' => 'Pour nourrir le cuir chevelu.',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.product-categories.index'));
        $this->assertDatabaseHas('product_categories', [
            'name' => 'Soins & huiles',
            'slug' => 'soins-huiles',
            'sort_order' => 6,
            'is_active' => true,
        ]);
    }

    public function test_category_names_must_be_unique(): void
    {
        $user = User::factory()->create();
        ProductCategory::factory()->create(['name' => 'Accessoires', 'slug' => 'accessoires']);

        $this->actingAs($user)->post(route('admin.product-categories.store'), ['name' => 'Accessoires'])
            ->assertSessionHasErrors('slug');

        $this->assertSame(1, ProductCategory::count());
    }

    public function test_authenticated_user_can_update_a_category(): void
    {
        $user = User::factory()->create();
        $category = ProductCategory::factory()->create();

        $this->actingAs($user)->patch(route('admin.product-categories.update', $category), [
            'name' => 'Nouveau nom',
        ])->assertRedirect(route('admin.product-categories.index'));

        $this->assertDatabaseHas('product_categories', [
            'id' => $category->id,
            'name' => 'Nouveau nom',
            'slug' => 'nouveau-nom',
            'is_active' => false,
        ]);
    }

    public function test_authenticated_user_can_reorder_categories(): void
    {
        $user = User::factory()->create();
        $first = ProductCategory::factory()->create(['sort_order' => 0]);
        $second = ProductCategory::factory()->create(['sort_order' => 1]);

        $this->actingAs($user)->patch(route('admin.product-categories.move-down', $first))
            ->assertRedirect(route('admin.product-categories.index'));

        $this->assertSame(1, $first->refresh()->sort_order);
        $this->assertSame(0, $second->refresh()->sort_order);
    }

    public function test_deleting_a_category_keeps_its_products_uncategorized(): void
    {
        $user = User::factory()->create();
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create(['product_category_id' => $category->id]);

        $this->actingAs($user)->delete(route('admin.product-categories.destroy', $category))
            ->assertRedirect(route('admin.product-categories.index'));

        $this->assertDatabaseMissing('product_categories', ['id' => $category->id]);
        $this->assertDatabaseHas('products', ['id' => $product->id, 'product_category_id' => null]);
    }

    public function test_a_product_can_be_assigned_to_a_category(): void
    {
        $user = User::factory()->create();
        $category = ProductCategory::factory()->create();

        $this->actingAs($user)->get(route('admin.products.create'))->assertOk()->assertSee($category->name);

        $this->actingAs($user)->post(route('admin.products.store'), [
            'product_category_id' => $category->id,
            'name' => 'Huile de ricin',
            'price' => '12.50',
            'is_active' => '1',
        ])->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseHas('products', ['name' => 'Huile de ricin', 'product_category_id' => $category->id]);

        $this->actingAs($user)->get(route('admin.products.index'))->assertOk()->assertSee($category->name);
    }

    public function test_a_product_cannot_use_an_unknown_category(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('admin.products.store'), [
            'product_category_id' => 999,
            'name' => 'Huile de ricin',
            'price' => '12.50',
        ])->assertSessionHasErrors('product_category_id');
    }
}
