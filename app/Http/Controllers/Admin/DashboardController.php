<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Subcategory;
use App\Models\GalleryImage;

class DashboardController extends Controller
{
     public function index()
    {
        $categoryCount = Category::where('is_active', 1)->count();
        $subcategoryCount = Subcategory::where('is_active', 1)->count();
        $productCount = Product::where('is_active', 1)->count();
        $featuredProductCount = Product::where('is_active', 1)->where('is_featured', 1)->count();
        $productImageCount = ProductImage::count();
        $newInquiryCount = Inquiry::where('status', 'new')->count();
        $totalInquiryCount = Inquiry::count();
        $galleryImageCount = GalleryImage::where('is_active', 1)->count();

        return view('admin.dashboard.index', compact(
            'categoryCount',
            'subcategoryCount',
            'productCount',
            'featuredProductCount',
            'productImageCount',
            'newInquiryCount',
            'totalInquiryCount',
            'galleryImageCount'
        ));
    }
}