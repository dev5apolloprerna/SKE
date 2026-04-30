<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;

class FrontCategoryController extends Controller
{
    public function show(string $slug)
    {
        $category      = Category::where('slug', $slug)->where('is_active', 1)->firstOrFail();
        $subcategories = $category->subcategories()->active()->get();
        $products      = Product::where('category_id', $category->id)
                            ->active()
                            ->with(['images','subcategory'])
                            ->paginate(12);
        $categories    = Category::active()->with('subcategories')->get();
        return view('front.products.category', compact('category','subcategories','products','categories'));
    }

    public function sub(string $catSlug, string $subSlug)
    {
        $category    = Category::where('slug', $catSlug)->where('is_active', 1)->firstOrFail();
        $subcategory = Subcategory::where('slug', $subSlug)
                        ->where('category_id', $category->id)
                        ->where('is_active', 1)
                        ->firstOrFail();
        $products    = Product::where('subcategory_id', $subcategory->id)
                        ->active()
                        ->with(['images','category'])
                        ->paginate(12);
        $categories  = Category::active()->with('subcategories')->get();
        return view('front.products.subcategory', compact('category','subcategory','products','categories'));
    }
}
