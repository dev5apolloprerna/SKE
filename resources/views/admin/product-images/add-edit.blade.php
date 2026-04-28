@extends('layouts.app')

@section('title', $image ? 'Edit Product Image' : 'Add Product Image')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            @include('common.alert')

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ $image ? 'Edit Product Image' : 'Add Product Image' }}</h4>
                        <div class="page-title-right">
                            <a href="{{ route('admin.product-images.index') }}"
                               class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST"
                  enctype="multipart/form-data"
                  action="{{ $image ? route('admin.product-images.update', $image->id) : route('admin.product-images.store') }}">
                @csrf

                @if($image)
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Product <span style="color:red;">*</span></label>
                                        <select name="product_id" class="form-control">
                                            <option value="">Select Product</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}"
                                                    {{ old('product_id', $image->product_id ?? '') == $product->id ? 'selected' : '' }}>
                                                    {{ $product->name }} - {{ $product->model_no }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('product_id'))
                                            <span class="text-danger">{{ $errors->first('product_id') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">
                                            Product Image
                                            @if(!$image)
                                                <span style="color:red;">*</span>
                                            @endif
                                        </label>
                                        <input type="file" name="image_path" class="form-control">

                                        @if($image && $image->image_path)
                                            <img src="{{ asset($image->image_path) }}"
                                                 width="100"
                                                 height="100"
                                                 class="mt-2 rounded border"
                                                 style="object-fit:cover;">
                                        @endif

                                        @if($errors->has('image_path'))
                                            <span class="text-danger">{{ $errors->first('image_path') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Alt Text</label>
                                        <input type="text"
                                               name="alt_text"
                                               class="form-control"
                                               value="{{ old('alt_text', $image->alt_text ?? '') }}">
                                        @if($errors->has('alt_text'))
                                            <span class="text-danger">{{ $errors->first('alt_text') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-md-3 mb-4">
                                        <label class="form-label">Sort Order</label>
                                        <input type="number"
                                               name="sort_order"
                                               class="form-control"
                                               value="{{ old('sort_order', $image->sort_order ?? 0) }}">
                                        @if($errors->has('sort_order'))
                                            <span class="text-danger">{{ $errors->first('sort_order') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-md-3 mb-4">
                                        <label class="form-label">Primary <span style="color:red;">*</span></label>
                                        <select name="is_primary" class="form-control">
                                            <option value="0" {{ old('is_primary', $image->is_primary ?? 0) == 0 ? 'selected' : '' }}>No</option>
                                            <option value="1" {{ old('is_primary', $image->is_primary ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
                                        </select>
                                        @if($errors->has('is_primary'))
                                            <span class="text-danger">{{ $errors->first('is_primary') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">
                                            {{ $image ? 'Update' : 'Submit' }}
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