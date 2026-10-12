<?php

namespace Tests\Feature;

use App\Mail\NewProductOrderNotification;
use App\Mail\ProductOrderConfirmation;
use App\Mail\ProductOrderStatusUpdated;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ProductOrderTest extends TestCase
{
    use RefreshDatabase;

    private function product(array $attributes = []): Product
    {
        return Product::factory()->create(array_merge([
            'name' => 'Huile capillaire',
            'slug' => 'huile-capillaire',
            'price' => 14.90,
            'stock_quantity' => 10,
            'is_active' => true,
        ], $attributes));
    }

    private function orderData(array $overrides = []): array
    {
        return array_merge([
            'client_name' => 'Marie Dupont',
            'client_email' => 'marie@example.com',
            'client_phone' => '06 12 34 56 78',
            'quantity' => 2,
            'notes' => 'Je passe samedi.',
        ], $overrides);
    }

    public function test_shop_links_to_the_order_form(): void
    {
        $product = $this->product();

        $this->get(route('products.index'))
            ->assertOk()
            ->assertSee(route('product-order.create', $product), false);

        $this->get(route('product-order.create', $product))
            ->assertOk()
            ->assertSee('Huile capillaire')
            ->assertSee('Valider ma commande');
    }

    public function test_client_can_order_and_both_emails_are_sent(): void
    {
        Mail::fake();
        $product = $this->product();

        $response = $this->post(route('product-order.store', $product), $this->orderData());

        $order = ProductOrder::firstOrFail();
        $response->assertRedirect(route('product-order.confirmation', $order->reference));

        $this->assertSame(ProductOrder::STATUS_PENDING, $order->status);
        $this->assertSame('Huile capillaire', $order->product_name);
        $this->assertSame(2, $order->quantity);
        $this->assertEquals(29.80, (float) $order->total_price);
        $this->assertStringStartsWith('CMD-', $order->reference);

        Mail::assertSent(NewProductOrderNotification::class, fn ($mail) => $mail->hasTo(config('salon.notification_email')));
        Mail::assertSent(ProductOrderConfirmation::class, fn ($mail) => $mail->hasTo('marie@example.com'));

        $this->get(route('product-order.confirmation', $order->reference))
            ->assertOk()
            ->assertSee($order->reference)
            ->assertSee('29,80 €');
    }

    public function test_same_client_cannot_order_the_same_product_twice_while_the_first_is_open(): void
    {
        Mail::fake();
        $product = $this->product();

        $this->post(route('product-order.store', $product), $this->orderData());

        // Same email with different case/spaces.
        $this->post(route('product-order.store', $product), $this->orderData(['client_email' => ' MARIE@example.com ', 'client_phone' => '0700000000']))
            ->assertSessionHasErrors('client_email');

        // Same phone number written differently, other email.
        $this->post(route('product-order.store', $product), $this->orderData(['client_email' => 'autre@example.com', 'client_phone' => '+33 6 12 34 56 78']))
            ->assertSessionHasErrors('client_email');

        $this->assertSame(1, ProductOrder::count());

        // Once confirmed, it is still open.
        ProductOrder::first()->update(['status' => ProductOrder::STATUS_CONFIRMED]);
        $this->post(route('product-order.store', $product), $this->orderData())->assertSessionHasErrors('client_email');
        $this->assertSame(1, ProductOrder::count());
    }

    public function test_client_can_order_again_once_served_or_cancelled(): void
    {
        Mail::fake();
        $product = $this->product();
        $first = ProductOrder::factory()->create([
            'product_id' => $product->id,
            'client_email' => 'marie@example.com',
            'client_phone' => '0612345678',
            'status' => ProductOrder::STATUS_CANCELLED,
        ]);

        $this->post(route('product-order.store', $product), $this->orderData())->assertSessionHasNoErrors();
        $this->assertSame(2, ProductOrder::count());

        ProductOrder::where('id', '!=', $first->id)->update(['status' => ProductOrder::STATUS_SERVED]);
        $this->post(route('product-order.store', $product), $this->orderData())->assertSessionHasNoErrors();
        $this->assertSame(3, ProductOrder::count());
    }

    public function test_client_can_order_another_product_while_one_is_open(): void
    {
        Mail::fake();
        $first = $this->product();
        $second = $this->product(['name' => 'Bonnet satin', 'slug' => 'bonnet-satin']);

        $this->post(route('product-order.store', $first), $this->orderData());
        $this->post(route('product-order.store', $second), $this->orderData())->assertSessionHasNoErrors();

        $this->assertSame(2, ProductOrder::count());
    }

    public function test_out_of_stock_or_too_many_items_cannot_be_ordered(): void
    {
        Mail::fake();
        $empty = $this->product(['stock_quantity' => 0]);
        $few = $this->product(['name' => 'Spray', 'slug' => 'spray', 'stock_quantity' => 2]);

        $this->get(route('products.index'))->assertSee('Indisponible');
        $this->post(route('product-order.store', $empty), $this->orderData(['quantity' => 1]))->assertSessionHasErrors('quantity');
        $this->post(route('product-order.store', $few), $this->orderData(['quantity' => 3]))->assertSessionHasErrors('quantity');

        $this->assertSame(0, ProductOrder::count());
    }

    public function test_admin_sees_orders_and_status_changes_email_the_client(): void
    {
        Mail::fake();
        $user = User::factory()->create();
        $order = ProductOrder::factory()->create(['client_email' => 'marie@example.com', 'product_name' => 'Huile capillaire']);

        $this->get(route('admin.product-orders.index'))->assertRedirect(route('login'));

        $this->actingAs($user)->get(route('admin.product-orders.index'))
            ->assertOk()
            ->assertSee($order->reference)
            ->assertSee('Huile capillaire');

        $this->actingAs($user)->patch(route('admin.product-orders.update', $order), ['status' => ProductOrder::STATUS_CONFIRMED])
            ->assertSessionHas('success');

        $this->assertSame(ProductOrder::STATUS_CONFIRMED, $order->fresh()->status);
        Mail::assertSent(ProductOrderStatusUpdated::class, fn ($mail) => $mail->hasTo('marie@example.com'));
    }

    public function test_admin_cannot_reopen_an_order_when_another_one_is_open(): void
    {
        Mail::fake();
        $user = User::factory()->create();
        $product = $this->product();
        $cancelled = ProductOrder::factory()->create(['product_id' => $product->id, 'client_email' => 'marie@example.com', 'status' => ProductOrder::STATUS_CANCELLED]);
        ProductOrder::factory()->create(['product_id' => $product->id, 'client_email' => 'marie@example.com', 'status' => ProductOrder::STATUS_PENDING]);

        $this->actingAs($user)->patch(route('admin.product-orders.update', $cancelled), ['status' => ProductOrder::STATUS_PENDING])
            ->assertSessionHas('error');

        $this->assertSame(ProductOrder::STATUS_CANCELLED, $cancelled->fresh()->status);
        Mail::assertNothingSent();
    }

    public function test_order_emails_render(): void
    {
        $order = ProductOrder::factory()->create(['status' => ProductOrder::STATUS_CONFIRMED]);

        $this->assertStringContainsString($order->reference, (new ProductOrderConfirmation($order))->render());
        $this->assertStringContainsString($order->client_phone, (new NewProductOrderNotification($order))->render());
        $this->assertStringContainsString('prête à être récupérée', (new ProductOrderStatusUpdated($order))->render());
    }
}
