<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\GalleryImage;

class GalleryController extends Controller
{
    public function index()
    {
        $categories = Category::active()->with('subcategories')->get();
        $images     = GalleryImage::active()->get();
        return view('front.pages.gallery', compact('categories','images'));
    }
}
