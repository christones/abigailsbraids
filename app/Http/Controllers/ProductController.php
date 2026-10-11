<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Show the shop page, optionally filtered on one category
     * (e.g. /boutique?categorie=soins-huiles).
     */
    public function index(Request $request): View
    {
        $categories = ProductCategory::query()->visible()->get();

        $currentCategory = null;

        if ($request->filled('categorie')) {
            $currentCategory = $categories->firstWhere('slug', $request->string('categorie')->toString());

            abort_if($currentCategory === null, 404);
        }

        $products = Product::query()
            ->where('is_active', true)
            ->when($currentCategory, fn ($query) => $query->where('product_category_id', $currentCategory->id))
            ->orderBy('sort_order')
            ->get();

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'currentCategory' => $currentCategory,
        ]);
    }

    /**
     * Show every shop category that has visible products.
     */
    public function categories(): View
    {
        return view('products.categories', [
            'categories' => ProductCategory::query()->visible()->get(),
        ]);
    }
}
