<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Product;

class FrontProductController extends Controller
{
    public function index()
    {
        $categories = Category::active()->with('subcategories')->get();
        $products   = Product::active()->with(['images','category','subcategory'])->paginate(12);
        return view('front.products.index', compact('categories','products'));
    }

    public function show(string $slug)
    {
        $product  = Product::where('slug', $slug)->where('is_active', 1)
                        ->with(['images','category','subcategory'])
                        ->firstOrFail();
        $related  = Product::where('subcategory_id', $product->subcategory_id)
                        ->where('id', '!=', $product->id)
                        ->active()
                        ->with('images')
                        ->take(4)
                        ->get();
        $categories = Category::active()->with('subcategories')->get();
        return view('front.products.detail', compact('product','related','categories'));
    }
}
