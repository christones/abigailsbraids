<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductOrderRequest;
use App\Mail\NewProductOrderNotification;
use App\Mail\ProductOrderConfirmation;
use App\Models\Product;
use App\Models\ProductOrder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ProductOrderController extends Controller
{
    /**
     * Show the order (reservation) form for a product.
     */
    public function create(Product $product): View
    {
        abort_unless($product->is_active, 404);

        return view('products.order.create', [
            'product' => $product->loadMissing('category'),
        ]);
    }

    /**
     * Store a new product order and email the salon and the client.
     */
    public function store(StoreProductOrderRequest $request, Product $product): RedirectResponse
    {
        abort_unless($product->is_active, 404);

        if (! $product->inStock()) {
            return back()->withInput()->withErrors([
                'quantity' => 'Ce produit est actuellement en rupture de stock.',
            ]);
        }

        $data = $request->validated();

        $order = DB::transaction(function () use ($data, $product) {
            // Re-check inside the transaction, in case the same client submits twice at once.
            if (ProductOrder::findOpenFor($product->id, $data['client_email'], $data['client_phone'])) {
                return null;
            }

            return ProductOrder::create([
                ...$data,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'unit_price' => $product->price,
                'total_price' => round((float) $product->price * $data['quantity'], 2),
                'status' => ProductOrder::STATUS_PENDING,
            ]);
        });

        if (! $order) {
            return back()->withInput()->withErrors([
                'client_email' => "Vous avez déjà une commande en cours pour « {$product->name} ».",
            ]);
        }

        $this->sendNotifications($order);

        return redirect()->route('product-order.confirmation', $order->reference);
    }

    /**
     * Show the confirmation page (addressed by the order's random reference,
     * so orders can't be browsed by id).
     */
    public function confirmation(ProductOrder $productOrder): View
    {
        return view('products.order.confirmation', [
            'order' => $productOrder->load('product'),
        ]);
    }

    /**
     * Email the salon and the client about the new order.
     */
    private function sendNotifications(ProductOrder $order): void
    {
        try {
            Mail::to(config('salon.notification_email'))->send(new NewProductOrderNotification($order));
        } catch (\Throwable $e) {
            Log::error('Failed to send new product order notification email.', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);
        }

        try {
            Mail::to($order->client_email)->send(new ProductOrderConfirmation($order));
        } catch (\Throwable $e) {
            Log::error('Failed to send product order confirmation email to client.', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
