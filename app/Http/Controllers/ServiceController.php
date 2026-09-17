<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Display all of the salon's services, grouped by category.
     */
    public function index(): View
    {
        $categories = ServiceCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->with(['services' => function ($query) {
                $query->where('is_active', true)->orderBy('sort_order')->with(['options' => function ($optionsQuery) {
                    $optionsQuery->where('is_active', true)->orderBy('sort_order');
                }]);
            }])
            ->get()
            ->filter(fn (ServiceCategory $category) => $category->services->isNotEmpty())
            ->values();

        $uncategorized = Service::query()
            ->where('is_active', true)
            ->whereNull('service_category_id')
            ->orderBy('sort_order')
            ->with(['options' => function ($optionsQuery) {
                $optionsQuery->where('is_active', true)->orderBy('sort_order');
            }])
            ->get();

        if ($uncategorized->isNotEmpty()) {
            $fallback = new ServiceCategory([
                'name' => 'Autres prestations',
                'slug' => 'autres-prestations',
            ]);
            $fallback->setRelation('services', $uncategorized);

            $categories->push($fallback);
        }

        return view('services', [
            'categories' => $categories,
        ]);
    }
}
