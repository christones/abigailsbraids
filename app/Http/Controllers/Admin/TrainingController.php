<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesImageUploads;
use App\Http\Controllers\Controller;
use App\Models\Training;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TrainingController extends Controller
{
    use HandlesImageUploads;

    /**
     * List every training (active and inactive) for management.
     */
    public function index(): View
    {
        $trainings = Training::query()->orderBy('sort_order')->get();

        return view('admin.trainings.index', [
            'trainings' => $trainings,
        ]);
    }

    /**
     * Show the form to create a new training.
     */
    public function create(): View
    {
        return view('admin.trainings.create');
    }

    /**
     * Store a newly created training.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $this->storeUploadedImage($request->file('image'), 'trainings');
        }

        $validated['slug'] = Str::slug($validated['name']);

        Training::create($validated);

        return redirect()->route('admin.trainings.index')->with('success', 'Formation créée.');
    }

    /**
     * Show the form to edit a training.
     */
    public function edit(Training $training): View
    {
        return view('admin.trainings.edit', [
            'training' => $training,
        ]);
    }

    /**
     * Update a training.
     */
    public function update(Request $request, Training $training): RedirectResponse
    {
        $validated = $this->validated($request);

        if ($request->hasFile('image')) {
            $this->deleteUploadedImage($training->image_path);
            $validated['image_path'] = $this->storeUploadedImage($request->file('image'), 'trainings');
        }

        $validated['slug'] = Str::slug($validated['name']);

        $training->update($validated);

        return redirect()->route('admin.trainings.index')->with('success', 'Formation mise à jour.');
    }

    /**
     * Delete a training.
     */
    public function destroy(Training $training): RedirectResponse
    {
        $this->deleteUploadedImage($training->image_path);
        $training->delete();

        return redirect()->route('admin.trainings.index')->with('success', 'Formation supprimée.');
    }

    /**
     * Validate the shared training fields.
     *
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'level' => ['nullable', 'string', 'max:100'],
            'duration_minutes' => ['required', 'integer', 'min:15', 'max:10080'],
            'price_from' => ['required', 'numeric', 'min:0', 'max:99999.99'],
            'image' => ['nullable', 'image', 'max:4096'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [], [
            'name' => 'nom',
            'description' => 'description',
            'level' => 'niveau',
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
