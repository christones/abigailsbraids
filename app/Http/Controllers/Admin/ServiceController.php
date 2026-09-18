<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesImageUploads;
use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ServiceController extends Controller
{
    use HandlesImageUploads;

    /**
     * List every service (active and inactive) for management.
     */
    public function index(): View
    {
        $services = Service::query()->with('category')->orderBy('sort_order')->get();

        return view('admin.services.index', [
            'services' => $services,
        ]);
    }

    /**
     * Show the form to create a new service.
     */
    public function create(): View
    {
        return view('admin.services.create', [
            'categories' => ServiceCategory::query()->orderBy('sort_order')->get(),
        ]);
    }

    /**
     * Store a newly created service.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $this->storeUploadedImage($request->file('image'), 'services');
        }

        $validated['slug'] = Str::slug($validated['name']);

        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'Prestation créée.');
    }

    /**
     * Show the form to edit a service.
     */
    public function edit(Service $service): View
    {
        return view('admin.services.edit', [
            'service' => $service,
            'categories' => ServiceCategory::query()->orderBy('sort_order')->get(),
        ]);
    }

    /**
     * Update a service.
     */
    public function update(Request $request, Service $service): RedirectResponse
    {
        $validated = $this->validated($request);

        if ($request->hasFile('image')) {
            $this->deleteUploadedImage($service->image_path);
            $validated['image_path'] = $this->storeUploadedImage($request->file('image'), 'services');
        }

        $validated['slug'] = Str::slug($validated['name']);

        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', 'Prestation mise à jour.');
    }

    /**
     * Delete a service.
     */
    public function destroy(Service $service): RedirectResponse
    {
        $this->deleteUploadedImage($service->image_path);
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Prestation supprimée.');
    }

    /**
     * Validate the shared service fields.
     *
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        $request->merge(['service_category_id' => $request->input('service_category_id') ?: null]);

        $data = $request->validate([
            'service_category_id' => ['nullable', 'exists:service_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'duration_minutes' => ['required', 'integer', 'min:15', 'max:1440'],
            'price_from' => ['required', 'numeric', 'min:0', 'max:99999.99'],
            'image' => ['nullable', 'image', 'max:4096'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [], [
            'service_category_id' => 'catégorie',
            'name' => 'nom',
            'description' => 'description',
            'duration_minutes' => 'durée',
            'price_from' => 'prix',
            'image' => 'image',
        ]);

        unset($data['image']);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
