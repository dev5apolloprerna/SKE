<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SubcategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $subcategories = Subcategory::with('category')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%");
            })
            ->orderBy('sort_order', 'asc')
            ->paginate(10);

        return view('admin.subcategories.index', compact('subcategories', 'search'));
    }
    public function manageByCategory(Request $request, $category_id)
{
    $category = Category::findOrFail($category_id);
    $search = $request->search;

    $subcategories = Subcategory::where('category_id', $category_id)
        ->when($search, function ($query) use ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        })
        ->orderBy('id', 'desc')
        ->paginate(10);

    $editSubcategory = null;

    return view('admin.subcategories.manage-category', compact(
        'category',
        'subcategories',
        'editSubcategory',
        'search'
    ));
}

public function storeByCategory(Request $request, $category_id)
{
    Category::findOrFail($category_id);

    $request->validate([
        'name' => 'required|max:160',
        'description' => 'nullable',
        'sort_order' => 'nullable|integer',
        'is_active' => 'required|in:0,1',
    ]);

    Subcategory::create([
        'category_id' => $category_id,
        'name' => $request->name,
        'slug' => $this->generateSubcategorySlug($request->name),
        'description' => $request->description,
        'sort_order' => $request->sort_order ?? 0,
        'is_active' => $request->is_active,
    ]);

    return redirect()->route('admin.categories.subcategories', $category_id)
        ->with('success', 'Subcategory added successfully.');
}

public function editByCategory(Request $request, $category_id, $id)
{
    $category = Category::findOrFail($category_id);
    $search = $request->search;

    $subcategories = Subcategory::where('category_id', $category_id)
        ->when($search, function ($query) use ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        })
        ->orderBy('id', 'desc')
        ->paginate(10);

    $editSubcategory = Subcategory::where('category_id', $category_id)
        ->where('id', $id)
        ->firstOrFail();

    return view('admin.subcategories.manage-category', compact(
        'category',
        'subcategories',
        'editSubcategory',
        'search'
    ));
}

public function updateByCategory(Request $request, $category_id, $id)
{
    $subcategory = Subcategory::where('category_id', $category_id)
        ->where('id', $id)
        ->firstOrFail();

    $request->validate([
        'name' => 'required|max:160',
        'description' => 'nullable',
        'sort_order' => 'nullable|integer',
        'is_active' => 'required|in:0,1',
    ]);

    $subcategory->update([
        'name' => $request->name,
        'slug' => $subcategory->name != $request->name
            ? $this->generateSubcategorySlug($request->name, $subcategory->id)
            : $subcategory->slug,
        'description' => $request->description,
        'sort_order' => $request->sort_order ?? 0,
        'is_active' => $request->is_active,
    ]);

    return redirect()->route('admin.categories.subcategories', $category_id)
        ->with('success', 'Subcategory updated successfully.');
}

public function deleteByCategory($category_id, $id)
{
    $subcategory = Subcategory::where('category_id', $category_id)
        ->where('id', $id)
        ->firstOrFail();

    $subcategory->delete();

    return redirect()->route('admin.categories.subcategories', $category_id)
        ->with('success', 'Subcategory deleted successfully.');
}

public function bulkDeleteByCategory(Request $request, $category_id)
{
    if (!$request->ids) {
        return response()->json([
            'status' => false,
            'message' => 'Please select records.',
        ]);
    }

    Subcategory::where('category_id', $category_id)
        ->whereIn('id', $request->ids)
        ->delete();

    return response()->json([
        'status' => true,
        'message' => 'Selected subcategories deleted successfully.',
    ]);
}

private function generateSubcategorySlug($name, $ignoreId = null)
{
    $slug = Str::slug($name);
    $originalSlug = $slug;
    $counter = 1;

    while (
        Subcategory::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
    ) {
        $slug = $originalSlug . '-' . $counter++;
    }

    return $slug;
}

    public function create()
    {
        $categories = Category::where('is_active', 1)
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.subcategories.add-edit', [
            'subcategory' => null,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|max:160|unique:subcategories,name',
            'description' => 'nullable',
            'sort_order' => 'nullable|integer',
            'is_active' => 'required|in:0,1',
        ]);

        Subcategory::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => $this->generateUniqueSlug($request->name),
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Subcategory added successfully.');
    }

    public function edit($slug)
    {
        $subcategory = Subcategory::where('slug', $slug)->firstOrFail();

        $categories = Category::where('is_active', 1)
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.subcategories.add-edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, $slug)
    {
        $subcategory = Subcategory::where('slug', $slug)->firstOrFail();

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => [
                'required',
                'max:160',
                Rule::unique('subcategories', 'name')->ignore($subcategory->id),
            ],
            'description' => 'nullable',
            'sort_order' => 'nullable|integer',
            'is_active' => 'required|in:0,1',
        ]);

        $subcategory->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => $subcategory->name !== $request->name
                ? $this->generateUniqueSlug($request->name, $subcategory->id)
                : $subcategory->slug,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Subcategory updated successfully.');
    }

    public function destroy($slug)
    {
        $subcategory = Subcategory::where('slug', $slug)->firstOrFail();
        $subcategory->delete();

        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Subcategory deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        if (!$request->ids) {
            return response()->json(['status' => false, 'message' => 'Please select records.']);
        }

        Subcategory::whereIn('slug', $request->ids)->delete();

        return response()->json(['status' => true, 'message' => 'Selected subcategories deleted successfully.']);
    }

    public function changeStatus($slug)
    {
        $subcategory = Subcategory::where('slug', $slug)->firstOrFail();
        $subcategory->is_active = $subcategory->is_active == 1 ? 0 : 1;
        $subcategory->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }

    private function generateUniqueSlug($name, $ignoreId = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (
            Subcategory::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter++;
        }

        return $slug;
    }
}