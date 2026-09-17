<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceOption;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceOptionController extends Controller
{
    /**
     * List every option/variant for a given service.
     */
    public function index(Service $service): View
    {
        $options = $service->options()->orderBy('sort_order')->get();

        return view('admin.services.options.index', [
            'service' => $service,
            'options' => $options,
        ]);
    }

    /**
     * Show the form to add a new option to a service.
     */
    public function create(Service $service): View
    {
        return view('admin.services.options.create', [
            'service' => $service,
        ]);
    }

    /**
     * Store a newly created option.
     */
    public function store(Request $request, Service $service): RedirectResponse
    {
        $validated = $this->validated($request);

        $service->options()->create($validated);

        return redirect()->route('admin.services.options.index', $service)->with('success', 'Option ajoutée.');
    }

    /**
     * Show the form to edit an option.
     */
    public function edit(Service $service, ServiceOption $option): View
    {
        return view('admin.services.options.edit', [
            'service' => $service,
            'option' => $option,
        ]);
    }

    /**
     * Update an option.
     */
    public function update(Request $request, Service $service, ServiceOption $option): RedirectResponse
    {
        $validated = $this->validated($request);

        $option->update($validated);

        return redirect()->route('admin.services.options.index', $service)->with('success', 'Option mise à jour.');
    }

    /**
     * Delete an option.
     */
    public function destroy(Service $service, ServiceOption $option): RedirectResponse
    {
        $option->delete();

        return redirect()->route('admin.services.options.index', $service)->with('success', 'Option supprimée.');
    }

    /**
     * Validate the shared option fields.
     *
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'group_label' => ['required', 'string', 'max:255'],
            'value_label' => ['required', 'string', 'max:255'],
            'extra_price' => ['nullable', 'numeric', 'min:0', 'max:99999.99'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [], [
            'group_label' => 'catégorie d\'option',
            'value_label' => 'valeur',
            'extra_price' => 'supplément',
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
