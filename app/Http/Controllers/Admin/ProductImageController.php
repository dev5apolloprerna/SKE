<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageUploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    private string $imageFolder = 'uploads/products';

    public function manageByProduct(Request $request, $product_id)
    {
        $product = Product::findOrFail($product_id);
        $search = $request->search;

        $images = ProductImage::where('product_id', $product_id)
            ->when($search, function ($query) use ($search) {
                $query->where('alt_text', 'LIKE', "%{$search}%");
            })
            ->orderBy('sort_order', 'asc')
            ->paginate(env('PER_PAGE_COUNT'));

        $editImage = null;

        return view('admin.product-images.manage-product', compact(
            'product',
            'images',
            'editImage',
            'search'
        ));
    }

    public function storeByProduct(Request $request, $product_id)
    {
        Product::findOrFail($product_id);

        $request->validate([
            'image_path' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'alt_text' => 'nullable|max:255',
            'sort_order' => 'nullable|integer',
            'is_primary' => 'required|in:0,1',
        ]);

        if ($request->is_primary == 1) {
            ProductImage::where('product_id', $product_id)->update(['is_primary' => 0]);
        }

        $imageUrl = ImageUploadHelper::upload(
            $request->file('image_path'),
            $this->imageFolder
        );

        ProductImage::create([
            'product_id' => $product_id,
            'image_url' => $imageUrl,
            'alt_text' => $request->alt_text,
            'sort_order' => $request->sort_order ?? 0,
            'is_primary' => $request->is_primary,
        ]);

        return redirect()->route('admin.products.images', $product_id)
            ->with('success', 'Product image added successfully.');
    }

    public function editByProduct($product_id, $id)
    {
        Product::findOrFail($product_id);

        $image = ProductImage::where('product_id', $product_id)
            ->where('id', $id)
            ->firstOrFail();

        return response()->json([
            'status' => true,
            'data' => $image,
            'image_url' => asset($image->image_url),
            'update_url' => route('admin.products.images.update', [$product_id, $image->id]),
        ]);
    }

    public function updateByProduct(Request $request, $product_id, $id)
    {
        $image = ProductImage::where('product_id', $product_id)
            ->where('id', $id)
            ->firstOrFail();

        $request->validate([
            'image_path' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'alt_text' => 'nullable|max:255',
            'sort_order' => 'nullable|integer',
            'is_primary' => 'required|in:0,1',
        ]);

        if ($request->is_primary == 1) {
            ProductImage::where('product_id', $product_id)
                ->where('id', '!=', $image->id)
                ->update(['is_primary' => 0]);
        }

        $imageUrl = $image->image_url;

        if ($request->hasFile('image_path')) {
            ImageUploadHelper::delete($image->image_url);

            $imageUrl = ImageUploadHelper::upload(
                $request->file('image_path'),
                $this->imageFolder
            );
        }

        $image->update([
            'image_url' => $imageUrl,
            'alt_text' => $request->alt_text,
            'sort_order' => $request->sort_order ?? 0,
            'is_primary' => $request->is_primary,
        ]);

        return redirect()->route('admin.products.images', $product_id)
            ->with('success', 'Product image updated successfully.');
    }

    public function deleteByProduct($product_id, $id)
    {
        $image = ProductImage::where('product_id', $product_id)
            ->where('id', $id)
            ->firstOrFail();

        ImageUploadHelper::delete($image->image_url);

        $image->delete();

        return redirect()->route('admin.products.images', $product_id)
            ->with('success', 'Product image deleted successfully.');
    }

    public function bulkDeleteByProduct(Request $request, $product_id)
    {
        if (!$request->ids) {
            return response()->json([
                'status' => false,
                'message' => 'Please select records.',
            ]);
        }

        $images = ProductImage::where('product_id', $product_id)
            ->whereIn('id', $request->ids)
            ->get();

        foreach ($images as $image) {
            ImageUploadHelper::delete($image->image_url);
            $image->delete();
        }

        return response()->json([
            'status' => true,
            'message' => 'Selected product images deleted successfully.',
        ]);
    }
}