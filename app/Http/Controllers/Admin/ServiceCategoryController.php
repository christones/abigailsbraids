<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ServiceCategoryController extends Controller
{
    /**
     * List every service category for management.
     */
    public function index(): View
    {
        $categories = ServiceCategory::query()
            ->withCount('services')
            ->orderBy('sort_order')
            ->get();

        return view('admin.service-categories.index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form to create a new category.
     */
    public function create(): View
    {
        return view('admin.service-categories.create');
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);

        $validated['slug'] = Str::slug($validated['name']);

        ServiceCategory::create($validated);

        return redirect()->route('admin.service-categories.index')->with('success', 'Catégorie créée.');
    }

    /**
     * Show the form to edit a category.
     */
    public function edit(ServiceCategory $serviceCategory): View
    {
        return view('admin.service-categories.edit', [
            'category' => $serviceCategory,
        ]);
    }

    /**
     * Update a category.
     */
    public function update(Request $request, ServiceCategory $serviceCategory): RedirectResponse
    {
        $validated = $this->validated($request);

        $validated['slug'] = Str::slug($validated['name']);

        $serviceCategory->update($validated);

        return redirect()->route('admin.service-categories.index')->with('success', 'Catégorie mise à jour.');
    }

    /**
     * Delete a category. Services in it are kept and simply become non classées.
     */
    public function destroy(ServiceCategory $serviceCategory): RedirectResponse
    {
        $serviceCategory->delete();

        return redirect()->route('admin.service-categories.index')->with('success', 'Catégorie supprimée. Les prestations concernées sont désormais "Non classées".');
    }

    /**
     * Validate the shared category fields.
     *
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [], [
            'name' => 'nom',
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
