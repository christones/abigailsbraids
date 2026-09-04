<?php

namespace App\Http\Controllers;

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
        return view('gallery');
    }

    /**
     * Display the contact page.
     */
    public function contact(): View
    {
        return view('contact');
    }
}
