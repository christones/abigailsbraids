<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesImageUploads;
use App\Http\Controllers\Concerns\HandlesSortOrder;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    use HandlesImageUploads, HandlesSortOrder;

    /**
     * List every product (active and inactive) for management.
     */
    public function index(): View
    {
        $products = Product::query()->orderBy('sort_order')->get();

        return view('admin.products.index', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form to create a new product.
     */
    public function create(): View
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $this->storeUploadedImage($request->file('image'), 'products');
        }

        $validated['slug'] = Str::slug($validated['name']);
        $validated['sort_order'] = $this->nextSortOrder(Product::query());

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produit créé.');
    }

    /**
     * Show the form to edit a product.
     */
    public function edit(Product $product): View
    {
        return view('admin.products.edit', [
            'product' => $product,
        ]);
    }

    /**
     * Update a product.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $this->validated($request);

        if ($request->hasFile('image')) {
            $this->deleteUploadedImage($product->image_path);
            $validated['image_path'] = $this->storeUploadedImage($request->file('image'), 'products');
        }

        $validated['slug'] = Str::slug($validated['name']);

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produit mis à jour.');
    }

    /**
     * Delete a product.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $this->deleteUploadedImage($product->image_path);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produit supprimé.');
    }

    /**
     * Move a product up (earlier) in the display order.
     */
    public function moveUp(Product $product): RedirectResponse
    {
        $previous = Product::query()
            ->where('sort_order', '<', $product->sort_order)
            ->orderByDesc('sort_order')
            ->first();

        if ($previous) {
            $this->swapSortOrder($product, $previous);
        }

        return redirect()->route('admin.products.index');
    }

    /**
     * Move a product down (later) in the display order.
     */
    public function moveDown(Product $product): RedirectResponse
    {
        $next = Product::query()
            ->where('sort_order', '>', $product->sort_order)
            ->orderBy('sort_order')
            ->first();

        if ($next) {
            $this->swapSortOrder($product, $next);
        }

        return redirect()->route('admin.products.index');
    }

    /**
     * Validate the shared product fields.
     *
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999.99'],
            'stock_quantity' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:4096'],
        ], [], [
            'name' => 'nom',
            'description' => 'description',
            'price' => 'prix',
            'stock_quantity' => 'stock',
            'image' => 'image',
        ]);

        unset($data['image']);
        $data['stock_quantity'] = $data['stock_quantity'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
