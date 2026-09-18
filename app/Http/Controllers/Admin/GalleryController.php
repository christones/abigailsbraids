<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesImageUploads;
use App\Http\Controllers\Concerns\HandlesSortOrder;
use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    use HandlesImageUploads, HandlesSortOrder;

    /**
     * List every gallery image for management.
     */
    public function index(): View
    {
        $images = GalleryImage::query()->orderBy('sort_order')->get();

        return view('admin.gallery.index', [
            'images' => $images,
        ]);
    }

    /**
     * Show the form to add a new gallery image.
     */
    public function create(): View
    {
        return view('admin.gallery.create');
    }

    /**
     * Store a newly added gallery image.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'image' => ['required', 'image', 'max:4096'],
            'label' => ['nullable', 'string', 'max:255'],
        ], [], [
            'image' => 'image',
            'label' => 'légende',
        ]);

        GalleryImage::create([
            'image_path' => $this->storeUploadedImage($request->file('image'), 'gallery'),
            'label' => $validated['label'] ?? null,
            'sort_order' => $this->nextSortOrder(GalleryImage::query()),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.gallery.index')->with('success', 'Photo ajoutée à la galerie.');
    }

    /**
     * Show the form to edit a gallery image's details.
     */
    public function edit(GalleryImage $galleryImage): View
    {
        return view('admin.gallery.edit', [
            'image' => $galleryImage,
        ]);
    }

    /**
     * Update a gallery image's details (label, visibility, or the photo itself).
     */
    public function update(Request $request, GalleryImage $galleryImage): RedirectResponse
    {
        $validated = $request->validate([
            'image' => ['nullable', 'image', 'max:4096'],
            'label' => ['nullable', 'string', 'max:255'],
        ], [], [
            'image' => 'image',
            'label' => 'légende',
        ]);

        $data = [
            'label' => $validated['label'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('image')) {
            $this->deleteUploadedImage($galleryImage->image_path);
            $data['image_path'] = $this->storeUploadedImage($request->file('image'), 'gallery');
        }

        $galleryImage->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Photo mise à jour.');
    }

    /**
     * Delete a gallery image.
     */
    public function destroy(GalleryImage $galleryImage): RedirectResponse
    {
        $this->deleteUploadedImage($galleryImage->image_path);
        $galleryImage->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Photo supprimée.');
    }

    /**
     * Move a gallery image up (earlier) in the display order.
     */
    public function moveUp(GalleryImage $galleryImage): RedirectResponse
    {
        $previous = GalleryImage::query()
            ->where('sort_order', '<', $galleryImage->sort_order)
            ->orderByDesc('sort_order')
            ->first();

        if ($previous) {
            $this->swapSortOrder($galleryImage, $previous);
        }

        return redirect()->route('admin.gallery.index');
    }

    /**
     * Move a gallery image down (later) in the display order.
     */
    public function moveDown(GalleryImage $galleryImage): RedirectResponse
    {
        $next = GalleryImage::query()
            ->where('sort_order', '>', $galleryImage->sort_order)
            ->orderBy('sort_order')
            ->first();

        if ($next) {
            $this->swapSortOrder($galleryImage, $next);
        }

        return redirect()->route('admin.gallery.index');
    }
}
