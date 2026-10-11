<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesImageUploads;
use App\Http\Controllers\Concerns\HandlesSortOrder;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductCategoryController extends Controller
{
    use HandlesImageUploads, HandlesSortOrder;

    /**
     * List every product category for management.
     */
    public function index(): View
    {
        $categories = ProductCategory::query()
            ->withCount('products')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('admin.product-categories.index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form to create a new category.
     */
    public function create(): View
    {
        return view('admin.product-categories.create');
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $this->storeUploadedImage($request->file('image'), 'product-categories');
        }

        $validated['sort_order'] = $this->nextSortOrder(ProductCategory::query());

        ProductCategory::create($validated);

        return redirect()->route('admin.product-categories.index')->with('success', 'Catégorie créée.');
    }

    /**
     * Show the form to edit a category.
     */
    public function edit(ProductCategory $productCategory): View
    {
        return view('admin.product-categories.edit', [
            'category' => $productCategory,
        ]);
    }

    /**
     * Update a category.
     */
    public function update(Request $request, ProductCategory $productCategory): RedirectResponse
    {
        $validated = $this->validated($request, $productCategory);

        if ($request->hasFile('image')) {
            $this->deleteUploadedImage($productCategory->image_path);
            $validated['image_path'] = $this->storeUploadedImage($request->file('image'), 'product-categories');
        }

        $productCategory->update($validated);

        return redirect()->route('admin.product-categories.index')->with('success', 'Catégorie mise à jour.');
    }

    /**
     * Delete a category. Its products are kept and simply become non classés.
     */
    public function destroy(ProductCategory $productCategory): RedirectResponse
    {
        // Detach explicitly so this also works on databases where the foreign
        // key "on delete set null" isn't enforced (e.g. SQLite without FKs).
        $productCategory->products()->update(['product_category_id' => null]);

        $this->deleteUploadedImage($productCategory->image_path);
        $productCategory->delete();

        return redirect()->route('admin.product-categories.index')->with('success', 'Catégorie supprimée. Les produits concernés sont désormais "Non classés".');
    }

    /**
     * Move a category up (earlier) in the display order.
     */
    public function moveUp(ProductCategory $productCategory): RedirectResponse
    {
        $previous = ProductCategory::query()
            ->where('sort_order', '<', $productCategory->sort_order)
            ->orderByDesc('sort_order')
            ->first();

        if ($previous) {
            $this->swapSortOrder($productCategory, $previous);
        }

        return redirect()->route('admin.product-categories.index');
    }

    /**
     * Move a category down (later) in the display order.
     */
    public function moveDown(ProductCategory $productCategory): RedirectResponse
    {
        $next = ProductCategory::query()
            ->where('sort_order', '>', $productCategory->sort_order)
            ->orderBy('sort_order')
            ->first();

        if ($next) {
            $this->swapSortOrder($productCategory, $next);
        }

        return redirect()->route('admin.product-categories.index');
    }

    /**
     * Validate the shared category fields.
     *
     * @return array<string, mixed>
     */
    private function validated(Request $request, ?ProductCategory $category = null): array
    {
        $request->merge(['slug' => Str::slug((string) $request->input('name'))]);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', Rule::unique('product_categories', 'slug')->ignore($category)],
            'description' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'max:4096'],
        ], [
            'slug.unique' => 'Une catégorie porte déjà ce nom.',
            'slug.required' => 'Le nom doit contenir au moins une lettre ou un chiffre.',
        ], [
            'name' => 'nom',
            'description' => 'description',
            'image' => 'image',
        ]);

        unset($data['image']);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
