<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display the "About" page.
     */
    public function about(): View
    {
        return view('about');
    }

    /**
     * Display the photo gallery.
     */
    public function gallery(): View
    {
        $images = GalleryImage::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('gallery', [
            'images' => $images,
        ]);
    }

    /**
     * Display the contact page.
     */
    public function contact(): View
    {
        return view('contact');
    }
}
