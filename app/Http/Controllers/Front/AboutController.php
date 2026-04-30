<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use App\Models\Category;

class AboutController extends Controller
{
    public function index()
    {
        $categories = Category::active()->with('subcategories')->get();
        return view('front.pages.about', compact('categories'));
    }
}
