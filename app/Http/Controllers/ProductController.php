<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Show the shop page.
     */
    public function index(): View
    {
        $products = Product::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('products.index', [
            'products' => $products,
        ]);
    }
}
