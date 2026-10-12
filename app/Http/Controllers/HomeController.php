<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\Service;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Number of shop categories previewed on the homepage.
     */
    private const HOME_PRODUCT_CATEGORIES = 4;

    /**
     * Display the homepage.
     */
    public function index(): View
    {
        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $visibleCategories = ProductCategory::query()->visible();

        // Catégories mises en avant dans la bannière promo de la boutique :
        // les catégories actives enregistrées en base, dans l'ordre de l'admin.
        $promoCategories = ProductCategory::query()
            ->where('is_active', true)
            ->withCount(['products' => fn ($query) => $query->where('is_active', true)])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('home', [
            'promoCategories' => $promoCategories,
            'services' => $services,
            'productCategories' => (clone $visibleCategories)->limit(self::HOME_PRODUCT_CATEGORIES)->get(),
            'hasMoreProductCategories' => $visibleCategories->count() > self::HOME_PRODUCT_CATEGORIES,
        ]);
    }
}
