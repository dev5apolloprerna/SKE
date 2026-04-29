<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductImageController extends Controller
{
    private string $uploadPath = 'uploads/products';

    public function index(Request $request)
    {
        $search = $request->search;

        $images = ProductImage::with('product')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('product', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('model_no', 'LIKE', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('admin.product-images.index', compact('images', 'search'));
    }
    public function manageByProduct(Request $request, $product_id)
{
    $product = Product::findOrFail($product_id);
    $search = $request->search;

    $images = ProductImage::where('product_id', $product_id)
        ->when($search, function ($query) use ($search) {
            $query->where('alt_text', 'LIKE', "%{$search}%");
        })
        ->orderBy('sort_order', 'asc')
        ->paginate(10);

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

    $file = $request->file('image_path');
    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    $file->move(public_path($this->uploadPath), $fileName);

    ProductImage::create([
        'product_id' => $product_id,
        'image_path' => $this->uploadPath . '/' . $fileName,
        'alt_text' => $request->alt_text,
        'sort_order' => $request->sort_order ?? 0,
        'is_primary' => $request->is_primary,
    ]);

    return redirect()->route('admin.products.images', $product_id)
        ->with('success', 'Product image added successfully.');
}

public function editByProduct(Request $request, $product_id, $id)
{
    $product = Product::findOrFail($product_id);
    $search = $request->search;

    $images = ProductImage::where('product_id', $product_id)
        ->when($search, function ($query) use ($search) {
            $query->where('alt_text', 'LIKE', "%{$search}%");
        })
        ->orderBy('sort_order', 'asc')
        ->paginate(10);

    $editImage = ProductImage::where('product_id', $product_id)
        ->where('id', $id)
        ->firstOrFail();

    return view('admin.product-images.manage-product', compact(
        'product',
        'images',
        'editImage',
        'search'
    ));
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

    $imagePath = $image->image_path;

    if ($request->hasFile('image_path')) {
        if ($image->image_path && File::exists(public_path($image->image_path))) {
            File::delete(public_path($image->image_path));
        }

        $file = $request->file('image_path');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($this->uploadPath), $fileName);

        $imagePath = $this->uploadPath . '/' . $fileName;
    }

    $image->update([
        'image_path' => $imagePath,
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

    if ($image->image_path && File::exists(public_path($image->image_path))) {
        File::delete(public_path($image->image_path));
    }

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
        if ($image->image_path && File::exists(public_path($image->image_path))) {
            File::delete(public_path($image->image_path));
        }

        $image->delete();
    }

    return response()->json([
        'status' => true,
        'message' => 'Selected product images deleted successfully.',
    ]);
}

    public function create()
    {
        $products = Product::where('is_active', 1)
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.product-images.add-edit', [
            'image' => null,
            'products' => $products,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'image_path' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'alt_text' => 'nullable|max:255',
            'sort_order' => 'nullable|integer',
            'is_primary' => 'required|in:0,1',
        ]);

        if ($request->is_primary == 1) {
            ProductImage::where('product_id', $request->product_id)->update(['is_primary' => 0]);
        }

        $file = $request->file('image_path');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($this->uploadPath), $fileName);

        ProductImage::create([
            'product_id' => $request->product_id,
            'image_path' => $this->uploadPath . '/' . $fileName,
            'alt_text' => $request->alt_text,
            'sort_order' => $request->sort_order ?? 0,
            'is_primary' => $request->is_primary,
        ]);

        return redirect()->route('admin.product-images.index')
            ->with('success', 'Product image added successfully.');
    }

    public function edit($id)
    {
        $image = ProductImage::findOrFail($id);

        $products = Product::where('is_active', 1)
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.product-images.add-edit', compact('image', 'products'));
    }

    public function update(Request $request, $id)
    {
        $image = ProductImage::findOrFail($id);

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'image_path' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'alt_text' => 'nullable|max:255',
            'sort_order' => 'nullable|integer',
            'is_primary' => 'required|in:0,1',
        ]);

        if ($request->is_primary == 1) {
            ProductImage::where('product_id', $request->product_id)
                ->where('id', '!=', $image->id)
                ->update(['is_primary' => 0]);
        }

        $imagePath = $image->image_path;

        if ($request->hasFile('image_path')) {
            $this->unlinkImage($image->image_path);

            $file = $request->file('image_path');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($this->uploadPath), $fileName);

            $imagePath = $this->uploadPath . '/' . $fileName;
        }

        $image->update([
            'product_id' => $request->product_id,
            'image_path' => $imagePath,
            'alt_text' => $request->alt_text,
            'sort_order' => $request->sort_order ?? 0,
            'is_primary' => $request->is_primary,
        ]);

        return redirect()->route('admin.product-images.index')
            ->with('success', 'Product image updated successfully.');
    }

    public function destroy($id)
    {
        $image = ProductImage::findOrFail($id);

        $this->unlinkImage($image->image_path);
        $image->delete();

        return redirect()->route('admin.product-images.index')
            ->with('success', 'Product image deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        if (!$request->ids) {
            return response()->json(['status' => false, 'message' => 'Please select records.']);
        }

        $images = ProductImage::whereIn('id', $request->ids)->get();

        foreach ($images as $image) {
            $this->unlinkImage($image->image_path);
            $image->delete();
        }

        return response()->json([
            'status' => true,
            'message' => 'Selected product images deleted successfully.',
        ]);
    }

    private function unlinkImage($path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}