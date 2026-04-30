<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Product;

class FrontHomeController extends Controller
{
    public function index()
    {
        $categories = Category::active()->with('subcategories')->get();
        $featured   = Product::featured()->with(['images','category','subcategory'])->take(6)->get();
        return view('front.pages.home', compact('categories', 'featured'));
    }
}
