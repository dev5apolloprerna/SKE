@extends('layouts.app')

@section('title', $product ? 'Edit Product' : 'Add Product')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            @include('common.alert')

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ $product ? 'Edit Product' : 'Add Product' }}</h4>
                        <div class="page-title-right">
                            <a href="{{ route('admin.products.index') }}"
                               class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST"
                  enctype="multipart/form-data"
                  action="{{ $product ? route('admin.products.update', $product->slug) : route('admin.products.store') }}">
                @csrf

                @if($product)
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Category <span style="color:red;">*</span></label>
                                        <select name="category_id" id="category_id" class="form-control">
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('category_id'))
                                            <span class="text-danger">{{ $errors->first('category_id') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Subcategory <span style="color:red;">*</span></label>
                                        <select name="subcategory_id" id="subcategory_id" class="form-control">
                                            <option value="">Select Subcategory</option>
                                            @foreach($subcategories as $subcategory)
                                                <option value="{{ $subcategory->id }}"
                                                    data-category="{{ $subcategory->category_id }}"
                                                    {{ old('subcategory_id', $product->subcategory_id ?? '') == $subcategory->id ? 'selected' : '' }}>
                                                    {{ $subcategory->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('subcategory_id'))
                                            <span class="text-danger">{{ $errors->first('subcategory_id') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Model No <span style="color:red;">*</span></label>
                                        <input type="text" name="model_no" class="form-control"
                                               value="{{ old('model_no', $product->model_no ?? '') }}">
                                        @if($errors->has('model_no'))
                                            <span class="text-danger">{{ $errors->first('model_no') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Product Name <span style="color:red;">*</span></label>
                                        <input type="text" name="name" class="form-control"
                                               value="{{ old('name', $product->name ?? '') }}">
                                        @if($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Slug</label>
                                        <input type="text" name="slug" class="form-control"
                                               value="{{ old('slug', $product->slug ?? '') }}">
                                        @if($errors->has('slug'))
                                            <span class="text-danger">{{ $errors->first('slug') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Product Images</label>
                                        <input type="file" name="images[]" class="form-control" multiple>
                                        @if($errors->has('images.*'))
                                            <span class="text-danger">{{ $errors->first('images.*') }}</span>
                                        @endif
                                    </div>

                                    @if($product && $product->images->count())
                                        <div class="col-md-12 mb-4">
                                            <label class="form-label">Uploaded Images</label>
                                            <div class="row">
                                                @foreach($product->images as $image)
                                                    <div class="col-md-2 mb-3">
                                                        <img src="{{ asset($image->image_path) }}"
                                                             class="img-fluid rounded border"
                                                             style="height:100px;object-fit:cover;width:100%;">
                                                        <form action="{{ route('admin.products.deleteImage', $image->id) }}"
                                                              method="POST"
                                                              onsubmit="return confirm('Are you sure you want to delete this image?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger mt-2 w-100">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-md-4 mb-4">
                                        <label class="form-label">Length MM</label>
                                        <input type="number" step="0.01" name="length_mm" class="form-control"
                                               value="{{ old('length_mm', $product->length_mm ?? '') }}">
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label class="form-label">Width MM</label>
                                        <input type="number" step="0.01" name="width_mm" class="form-control"
                                               value="{{ old('width_mm', $product->width_mm ?? '') }}">
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label class="form-label">Height MM</label>
                                        <input type="number" step="0.01" name="height_mm" class="form-control"
                                               value="{{ old('height_mm', $product->height_mm ?? '') }}">
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Featured <span style="color:red;">*</span></label>
                                        <select name="is_featured" class="form-control">
                                            <option value="0" {{ old('is_featured', $product->is_featured ?? 0) == 0 ? 'selected' : '' }}>No</option>
                                            <option value="1" {{ old('is_featured', $product->is_featured ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Status <span style="color:red;">*</span></label>
                                        <select name="is_active" class="form-control">
                                            <option value="1" {{ old('is_active', $product->is_active ?? 1) == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ old('is_active', $product->is_active ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <label class="form-label">Short Description</label>
                                        <textarea name="short_description" class="form-control" rows="3">{{ old('short_description', $product->short_description ?? '') }}</textarea>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <label class="form-label">Long Description</label>
                                        <textarea name="long_description" class="form-control" rows="4">{{ old('long_description', $product->long_description ?? '') }}</textarea>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <label class="form-label">Specification Notes</label>
                                        <textarea name="specification_notes" class="form-control" rows="3">{{ old('specification_notes', $product->specifications['notes'] ?? '') }}</textarea>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Source Page</label>
                                        <input type="text" name="source_page" class="form-control"
                                               value="{{ old('source_page', $product->source_page ?? '') }}">
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">SEO Title</label>
                                        <input type="text" name="seo_title" class="form-control"
                                               value="{{ old('seo_title', $product->seo_title ?? '') }}">
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <label class="form-label">SEO Description</label>
                                        <textarea name="seo_description" class="form-control" rows="3">{{ old('seo_description', $product->seo_description ?? '') }}</textarea>
                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">
                                            {{ $product ? 'Update' : 'Submit' }}
                                        </button>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('#category_id').on('change', function () {
        let categoryId = $(this).val();

        $('#subcategory_id').html('<option value="">Select Subcategory</option>');

        if (categoryId) {
            $.ajax({
                url: "{{ url('admin/get-subcategories') }}/" + categoryId,
                type: "GET",
                success: function (data) {
                    $.each(data, function (key, value) {
                        $('#subcategory_id').append(
                            '<option value="' + value.id + '">' + value.name + '</option>'
                        );
                    });
                }
            });
        }
    });
</script>
@endsection