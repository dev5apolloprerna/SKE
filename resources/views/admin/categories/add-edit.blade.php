@extends('layouts.app')

@section('title', $category->exists ? 'Edit Category' : 'Add Category')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            {{-- Alert Messages --}}
            @include('common.alert')

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ $category->exists ? 'Edit Category' : 'Add Category' }}</h4>
                        <div class="page-title-right">
                            <a href="{{ route('admin.categories.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <form method="POST"
                                  action="{{ $category->exists ? route('admin.categories.update', $category->slug) : route('admin.categories.store') }}"
                                  enctype="multipart/form-data">
                                @csrf
                                @if($category->exists)
                                    @method('PUT')
                                @endif

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="mb-3">
                                            <label class="form-label">Category Name <span style="color:red;">*</span></label>
                                            <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" placeholder="Enter category name">
                                            @if($errors->has('name'))
                                                <span class="text-danger">
                                                    {{ $errors->first('name') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="mb-3">
                                            <label class="form-label">Image</label>
                                            <input type="file" name="image_url" class="form-control" accept="image/*">
                                            @if($errors->has('image_url'))
                                                <span class="text-danger">
                                                    {{ $errors->first('image_url') }}
                                                </span>
                                            @endif

                                            @if($category->image_url)
                                                <div class="mt-2">
                                                    <img src="{{ asset($category->image_url) }}" alt="{{ $category->name }}" width="100" height="70" style="object-fit:cover;">
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="mb-3">
                                            <label class="form-label">Sort Order</label>
                                            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $category->sort_order ?? 0) }}" placeholder="Enter sort order">
                                            @if($errors->has('sort_order'))
                                                <span class="text-danger">
                                                    {{ $errors->first('sort_order') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="mb-3">
                                            <label class="form-label">Status <span style="color:red;">*</span></label>
                                            <select name="is_active" class="form-control">
                                                <option value="1" {{ old('is_active', $category->is_active ?? 1) == 1 ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ old('is_active', $category->is_active ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                            @if($errors->has('is_active'))
                                                <span class="text-danger">
                                                    {{ $errors->first('is_active') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea name="description" class="form-control" rows="4" placeholder="Enter description">{{ old('description', $category->description) }}</textarea>
                                            @if($errors->has('description'))
                                                <span class="text-danger">
                                                    {{ $errors->first('description') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> {{ $category->exists ? 'Update' : 'Submit' }}
                                </button>
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
