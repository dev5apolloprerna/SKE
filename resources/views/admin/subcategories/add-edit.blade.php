@extends('layouts.app')

@section('title', $subcategory ? 'Edit Subcategory' : 'Add Subcategory')

@section('content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            @include('common.alert')

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">
                            {{ $subcategory ? 'Edit Subcategory' : 'Add Subcategory' }}
                        </h4>
                        <div class="page-title-right">
                            <a href="{{ route('admin.subcategories.index') }}"
                               class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
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
                                  action="{{ $subcategory ? route('admin.subcategories.update', $subcategory->slug) : route('admin.subcategories.store') }}">
                                @csrf

                                @if($subcategory)
                                    @method('PUT')
                                @endif

                                <div class="row">

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">
                                            Category <span style="color:red;">*</span>
                                        </label>
                                        <select name="category_id" class="form-control">
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id', $subcategory->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('category_id'))
                                            <span class="text-danger">
                                                {{ $errors->first('category_id') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">
                                            Subcategory Name <span style="color:red;">*</span>
                                        </label>
                                        <input type="text"
                                               name="name"
                                               class="form-control"
                                               value="{{ old('name', $subcategory->name ?? '') }}">
                                        @if($errors->has('name'))
                                            <span class="text-danger">
                                                {{ $errors->first('name') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Sort Order</label>
                                        <input type="number"
                                               name="sort_order"
                                               class="form-control"
                                               value="{{ old('sort_order', $subcategory->sort_order ?? 0) }}">
                                        @if($errors->has('sort_order'))
                                            <span class="text-danger">
                                                {{ $errors->first('sort_order') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">
                                            Status <span style="color:red;">*</span>
                                        </label>
                                        <select name="is_active" class="form-control">
                                            <option value="1" {{ old('is_active', $subcategory->is_active ?? 1) == 1 ? 'selected' : '' }}>
                                                Active
                                            </option>
                                            <option value="0" {{ old('is_active', $subcategory->is_active ?? 1) == 0 ? 'selected' : '' }}>
                                                Inactive
                                            </option>
                                        </select>
                                        @if($errors->has('is_active'))
                                            <span class="text-danger">
                                                {{ $errors->first('is_active') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <label class="form-label">Description</label>
                                        <textarea name="description"
                                                  class="form-control"
                                                  rows="4">{{ old('description', $subcategory->description ?? '') }}</textarea>
                                        @if($errors->has('description'))
                                            <span class="text-danger">
                                                {{ $errors->first('description') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">
                                            {{ $subcategory ? 'Update' : 'Submit' }}
                                        </button>
                                    </div>

                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection