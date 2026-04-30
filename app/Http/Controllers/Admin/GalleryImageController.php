<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageUploadHelper;
use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\Request;

class GalleryImageController extends Controller
{
    private string $imageFolder = 'uploads/gallery';

    /* ===============================
        LISTING
    =============================== */

    public function index(Request $request)
    {
        $search = $request->search;

        $galleryImages = GalleryImage::when($search, function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%");
            })
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(env('PER_PAGE_COUNT'));

        $editGalleryImage = null;

        return view('admin.gallery-images.index', compact(
            'galleryImages',
            'editGalleryImage',
            'search'
        ));
    }

    /* ===============================
        STORE
    =============================== */

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|max:200',
            'image_path' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable',
            'sort_order' => 'nullable|integer',
            'is_active' => 'required|in:0,1',
        ]);

        $imageUrl = ImageUploadHelper::upload(
            $request->file('image_path'),
            $this->imageFolder
        );

        GalleryImage::create([
            'title'       => $request->title,
            'image_url'   => $imageUrl,
            'description' => $request->description,
            'sort_order'  => $request->sort_order ?? 0,
            'is_active'   => $request->is_active,
        ]);

        return redirect()->route('admin.gallery-images.index')
            ->with('success', 'Gallery image added successfully.');
    }

    /* ===============================
        EDIT
        Note: Edit is handled by modal popup from listing page.
    =============================== */

    public function edit($id)
    {
        return redirect()->route('admin.gallery-images.index');
    }

    /* ===============================
        UPDATE
    =============================== */

    public function update(Request $request, $id)
    {
        $galleryImage = GalleryImage::findOrFail($id);

        $request->validate([
            'title' => 'nullable|max:200',
            'image_path' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable',
            'sort_order' => 'nullable|integer',
            'is_active' => 'required|in:0,1',
        ]);

        $imageUrl = $galleryImage->image_url;

        if ($request->hasFile('image_path')) {

            ImageUploadHelper::delete($galleryImage->image_url);

            $imageUrl = ImageUploadHelper::upload(
                $request->file('image_path'),
                $this->imageFolder
            );
        }

        $galleryImage->update([
            'title'       => $request->title,
            'image_url'   => $imageUrl,
            'description' => $request->description,
            'sort_order'  => $request->sort_order ?? 0,
            'is_active'   => $request->is_active,
        ]);

        return redirect()->route('admin.gallery-images.index')
            ->with('success', 'Gallery image updated successfully.');
    }

    /* ===============================
        DELETE
    =============================== */

    public function destroy($id)
    {
        $galleryImage = GalleryImage::findOrFail($id);

        ImageUploadHelper::delete($galleryImage->image_url);

        $galleryImage->delete();

        return redirect()->route('admin.gallery-images.index')
            ->with('success', 'Gallery image deleted successfully.');
    }

    /* ===============================
        BULK DELETE
    =============================== */

    public function bulkDelete(Request $request)
    {
        if (!$request->ids) {
            return response()->json([
                'status' => false,
                'message' => 'Please select records.',
            ]);
        }

        $galleryImages = GalleryImage::whereIn('id', $request->ids)->get();

        foreach ($galleryImages as $galleryImage) {
            ImageUploadHelper::delete($galleryImage->image_url);
            $galleryImage->delete();
        }

        return response()->json([
            'status' => true,
            'message' => 'Selected gallery images deleted successfully.',
        ]);
    }
}