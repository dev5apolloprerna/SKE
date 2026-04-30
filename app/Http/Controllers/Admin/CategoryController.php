<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageUploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    private string $imageFolder = 'uploads/categories';

    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        $categories = $query->orderBy('sort_order', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(10)
            ->appends($request->query());

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $category = new Category();

        return view('admin.categories.add-edit', compact('category'));
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());

        $category = new Category();

        $category->name = $request->name;
        $category->slug = $this->uniqueSlug($request->name);
        $category->description = $request->description;
        $category->sort_order = $request->sort_order ?? 0;
        $category->is_active = $request->is_active ?? 1;

        if ($request->hasFile('image_url')) {
            $category->image_url = ImageUploadHelper::upload(
                $request->file('image_url'),
                $this->imageFolder
            );
        }

        $category->save();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category added successfully.');
    }

    public function edit(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        return view('admin.categories.add-edit', compact('category'));
    }

    public function update(Request $request, string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $request->validate($this->rules($category->id));

        $category->name = $request->name;
        $category->slug = $this->uniqueSlug($request->name, $category->id);
        $category->description = $request->description;
        $category->sort_order = $request->sort_order ?? 0;
        $category->is_active = $request->is_active ?? 1;

        if ($request->hasFile('image_url')) {
            ImageUploadHelper::delete($category->image_url);

            $category->image_url = ImageUploadHelper::upload(
                $request->file('image_url'),
                $this->imageFolder
            );
        }

        $category->save();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        ImageUploadHelper::delete($category->image_url);

        $category->delete();

        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully.',
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'slugs' => ['required', 'array'],
            'slugs.*' => ['required', 'string'],
        ]);

        $categories = Category::whereIn('slug', $request->slugs)->get();

        foreach ($categories as $category) {
            ImageUploadHelper::delete($category->image_url);
            $category->delete();
        }

        return response()->json([
            'status' => true,
            'message' => 'Selected categories deleted successfully.',
        ]);
    }

    public function changeStatus(Request $request)
    {
        $request->validate([
            'slug' => ['required', 'string'],
            'status' => ['required', 'in:0,1'],
        ]);

        $category = Category::where('slug', $request->slug)->firstOrFail();

        $category->is_active = $request->status;
        $category->save();

        return response()->json([
            'status' => true,
            'message' => 'Status changed successfully.',
        ]);
    }

    private function rules(?int $ignoreId = null): array
    {
        return [
            'name' => [
                'required',
                'max:160',
                Rule::unique('categories', 'name')->ignore($ignoreId),
            ],
            'description' => ['nullable'],
            'image_url' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['required', 'in:0,1'],
        ];
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        while (
            Category::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter++;
        }

        return $slug;
    }
}