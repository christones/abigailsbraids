<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $response = $this->get(route('admin.products.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_see_products(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.products.index'));

        $response->assertOk();
        $response->assertSee($product->name);
    }

    public function test_authenticated_user_can_create_a_product(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.products.store'), [
            'name' => 'Huile capillaire',
            'description' => 'Une huile nourrissante.',
            'price' => 14.90,
            'stock_quantity' => 20,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', [
            'name' => 'Huile capillaire',
            'slug' => 'huile-capillaire',
        ]);
    }

    public function test_authenticated_user_can_update_a_product(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->patch(route('admin.products.update', $product), [
            'name' => 'Produit mis à jour',
            'price' => $product->price,
            'stock_quantity' => 5,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Produit mis à jour',
            'stock_quantity' => 5,
        ]);
    }

    public function test_authenticated_user_can_reorder_products(): void
    {
        $user = User::factory()->create();
        $first = Product::factory()->create(['sort_order' => 0]);
        $second = Product::factory()->create(['sort_order' => 1]);

        $response = $this->actingAs($user)->patch(route('admin.products.move-down', $first));

        $response->assertRedirect(route('admin.products.index'));
        $this->assertSame(1, $first->refresh()->sort_order);
        $this->assertSame(0, $second->refresh()->sort_order);
    }

    public function test_authenticated_user_can_delete_a_product(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->delete(route('admin.products.destroy', $product));

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
