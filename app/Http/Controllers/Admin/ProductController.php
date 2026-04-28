<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    private string $uploadPath = 'uploads/products';

    public function index(Request $request)
    {
        $search = $request->search;

        $products = Product::with(['category', 'subcategory', 'primaryImage'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('model_no', 'LIKE', "%{$search}%")
                        ->orWhereHas('category', fn ($c) => $c->where('name', 'LIKE', "%{$search}%"))
                        ->orWhereHas('subcategory', fn ($s) => $s->where('name', 'LIKE', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(10);

        return view('admin.products.index', compact('products', 'search'));
    }

    public function create()
    {
        $categories = Category::where('is_active', 1)->orderBy('name', 'asc')->get();
        $subcategories = Subcategory::where('is_active', 1)->orderBy('name', 'asc')->get();

        return view('admin.products.add-edit', [
            'product' => null,
            'categories' => $categories,
            'subcategories' => $subcategories,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'model_no' => 'required|max:100|unique:products,model_no',
            'name' => 'required|max:180',
            'slug' => 'nullable|max:220|unique:products,slug',
            'short_description' => 'nullable|max:500',
            'long_description' => 'nullable',
            'length_mm' => 'nullable|numeric',
            'width_mm' => 'nullable|numeric',
            'height_mm' => 'nullable|numeric',
            'specification_notes' => 'nullable',
            'source_page' => 'nullable|max:50',
            'seo_title' => 'nullable|max:255',
            'seo_description' => 'nullable|max:500',
            'is_featured' => 'required|in:0,1',
            'is_active' => 'required|in:0,1',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $slug = $request->slug ?: $request->model_no . '-' . $request->name;

        $product = Product::create([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'model_no' => $request->model_no,
            'name' => $request->name,
            'slug' => $this->generateUniqueSlug($slug),
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'length_mm' => $request->length_mm,
            'width_mm' => $request->width_mm,
            'height_mm' => $request->height_mm,
            'specifications' => [
                'notes' => $request->specification_notes,
            ],
            'source_page' => $request->source_page,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'is_featured' => $request->is_featured,
            'is_active' => $request->is_active,
        ]);

        $this->uploadImages($request, $product);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product added successfully.');
    }

    public function edit($slug)
    {
        $product = Product::with('images')->where('slug', $slug)->firstOrFail();
        $categories = Category::where('is_active', 1)->orderBy('name', 'asc')->get();
        $subcategories = Subcategory::where('is_active', 1)->orderBy('name', 'asc')->get();

        return view('admin.products.add-edit', compact('product', 'categories', 'subcategories'));
    }

    public function update(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'model_no' => [
                'required',
                'max:100',
                Rule::unique('products', 'model_no')->ignore($product->id),
            ],
            'name' => 'required|max:180',
            'slug' => [
                'nullable',
                'max:220',
                Rule::unique('products', 'slug')->ignore($product->id),
            ],
            'short_description' => 'nullable|max:500',
            'long_description' => 'nullable',
            'length_mm' => 'nullable|numeric',
            'width_mm' => 'nullable|numeric',
            'height_mm' => 'nullable|numeric',
            'specification_notes' => 'nullable',
            'source_page' => 'nullable|max:50',
            'seo_title' => 'nullable|max:255',
            'seo_description' => 'nullable|max:500',
            'is_featured' => 'required|in:0,1',
            'is_active' => 'required|in:0,1',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $newSlug = $request->slug ?: $request->model_no . '-' . $request->name;

        $product->update([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'model_no' => $request->model_no,
            'name' => $request->name,
            'slug' => $this->generateUniqueSlug($newSlug, $product->id),
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'length_mm' => $request->length_mm,
            'width_mm' => $request->width_mm,
            'height_mm' => $request->height_mm,
            'specifications' => [
                'notes' => $request->specification_notes,
            ],
            'source_page' => $request->source_page,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'is_featured' => $request->is_featured,
            'is_active' => $request->is_active,
        ]);

        $this->uploadImages($request, $product);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy($slug)
    {
        $product = Product::with('images')->where('slug', $slug)->firstOrFail();

        foreach ($product->images as $image) {
            $this->unlinkImage($image->image_path);
            $image->delete();
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        if (!$request->ids) {
            return response()->json(['status' => false, 'message' => 'Please select records.']);
        }

        $products = Product::with('images')->whereIn('slug', $request->ids)->get();

        foreach ($products as $product) {
            foreach ($product->images as $image) {
                $this->unlinkImage($image->image_path);
                $image->delete();
            }

            $product->delete();
        }

        return response()->json(['status' => true, 'message' => 'Selected products deleted successfully.']);
    }

    public function changeStatus($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $product->is_active = $product->is_active == 1 ? 0 : 1;
        $product->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }

    public function getSubcategories($category_id)
    {
        return Subcategory::where('category_id', $category_id)
            ->where('is_active', 1)
            ->orderBy('name', 'asc')
            ->get();
    }

    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);
        $this->unlinkImage($image->image_path);
        $image->delete();

        return redirect()->back()->with('success', 'Image deleted successfully.');
    }

    private function uploadImages(Request $request, Product $product): void
    {
        if (!$request->hasFile('images')) {
            return;
        }

        foreach ($request->file('images') as $key => $file) {
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($this->uploadPath), $fileName);

            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $this->uploadPath . '/' . $fileName,
                'alt_text' => $product->name,
                'sort_order' => $key,
                'is_primary' => $product->images()->count() == 0 ? 1 : 0,
            ]);
        }
    }

    private function unlinkImage($path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }

    private function generateUniqueSlug($value, $ignoreId = null): string
    {
        $slug = Str::slug($value);
        $originalSlug = $slug;
        $counter = 1;

        while (
            Product::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter++;
        }

        return $slug;
    }
}