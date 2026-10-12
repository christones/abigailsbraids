<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ProductOrderStatusUpdated;
use App\Models\ProductOrder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductOrderController extends Controller
{
    /**
     * List the shop orders, optionally filtered by status.
     */
    public function index(Request $request): View
    {
        $status = $request->string('statut')->toString();

        $orders = ProductOrder::query()
            ->with('product')
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $counts = ProductOrder::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.product-orders.index', [
            'orders' => $orders,
            'status' => $status,
            'counts' => $counts,
        ]);
    }

    /**
     * Change the status of an order and let the client know by email.
     */
    public function update(Request $request, ProductOrder $productOrder): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys(ProductOrder::statusLabels()))],
        ]);

        // Re-opening a served/cancelled order must not create a second open
        // order for the same client and product.
        if (in_array($validated['status'], ProductOrder::OPEN_STATUSES, true) && ! $productOrder->isOpen()) {
            $other = ProductOrder::findOpenFor((int) $productOrder->product_id, $productOrder->client_email, $productOrder->client_phone);

            if ($other && ! $other->is($productOrder)) {
                return back()->with('error', 'Cette cliente a déjà une autre commande en cours pour ce produit ('.$other->reference.').');
            }
        }

        $previous = $productOrder->status;
        $productOrder->update($validated);

        if ($previous !== $productOrder->status) {
            try {
                Mail::to($productOrder->client_email)->send(new ProductOrderStatusUpdated($productOrder));
            } catch (\Throwable $e) {
                Log::error('Failed to send product order status email.', [
                    'order_id' => $productOrder->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return back()->with('success', 'Commande '.$productOrder->reference.' : '.$productOrder->statusLabel().'. La cliente a été prévenue par e-mail.');
    }

    /**
     * Delete an order.
     */
    public function destroy(ProductOrder $productOrder): RedirectResponse
    {
        $productOrder->delete();

        return back()->with('success', 'Commande supprimée.');
    }
}
