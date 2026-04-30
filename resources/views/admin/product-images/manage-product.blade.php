@extends('layouts.app')

@section('title', 'Manage Product Images')

@section('content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            @include('common.alert')

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">
                            Manage Images - {{ $product->name }} / {{ $product->model_no }}
                        </h4>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">

                {{-- Add Left --}}
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Add Product Image</h5>
                        </div>
                        <div class="card-body">

                            <form method="POST"
                                  enctype="multipart/form-data"
                                  action="{{ route('admin.products.images.store', $product->id) }}">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">
                                        Product Image <span style="color:red;">*</span>
                                    </label>
                                    <input type="file" name="image_path" class="form-control">

                                    @if($errors->has('image_path'))
                                        <span class="text-danger">
                                            {{ $errors->first('image_path') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Alt Text</label>
                                    <input type="text"
                                           name="alt_text"
                                           class="form-control"
                                           value="{{ old('alt_text') }}">

                                    @if($errors->has('alt_text'))
                                        <span class="text-danger">
                                            {{ $errors->first('alt_text') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Sort Order</label>
                                    <input type="number"
                                           name="sort_order"
                                           class="form-control"
                                           value="{{ old('sort_order', 0) }}">

                                    @if($errors->has('sort_order'))
                                        <span class="text-danger">
                                            {{ $errors->first('sort_order') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        Primary <span style="color:red;">*</span>
                                    </label>
                                    <select name="is_primary" class="form-control">
                                        <option value="0" {{ old('is_primary', 0) == 0 ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ old('is_primary', 0) == 1 ? 'selected' : '' }}>Yes</option>
                                    </select>

                                    @if($errors->has('is_primary'))
                                        <span class="text-danger">
                                            {{ $errors->first('is_primary') }}
                                        </span>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </form>

                        </div>
                    </div>
                </div>

                {{-- Listing Right --}}
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Product Image List</h5>
                        </div>

                        <div class="card-body">

                            <form method="GET"
                                  action="{{ route('admin.products.images', $product->id) }}"
                                  class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Search Image</label>
                                        <input type="text"
                                               name="search"
                                               value="{{ request('search') }}"
                                               class="form-control"
                                               placeholder="Search by alt text">
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                        <a href="{{ route('admin.products.images', $product->id) }}"
                                           class="btn btn-secondary">
                                            Reset
                                        </a>
                                    </div>
                                </div>
                            </form>

                            <button type="button" id="bulkDelete" class="btn btn-danger btn-sm mb-3">
                                <i class="fas fa-trash"></i> Bulk Delete
                            </button>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="selectAll"></th>
                                            <th>Image</th>
                                            <th>Image Link</th>
                                            <th>Alt Text</th>
                                            <th>Sort Order</th>
                                            <th>Primary</th>
                                            <th width="120">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($images as $image)
                                            <tr>
                                                <td>
                                                    <input type="checkbox"
                                                           class="rowCheckbox"
                                                           value="{{ $image->id }}">
                                                </td>
                                                <td>
                                                    <a href="{{ asset($image->image_url) }}" target="_blank">
                                                        <img src="{{ asset($image->image_url) }}"
                                                             width="70"
                                                             height="70"
                                                             style="object-fit:cover;border-radius:6px;">
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ asset($image->image_url) }}" target="_blank">
                                                        View Image
                                                    </a>
                                                </td>
                                                <td>{{ $image->alt_text ?? '-' }}</td>
                                                <td>{{ $image->sort_order }}</td>
                                                <td>
                                                    @if($image->is_primary == 1)
                                                        <span class="badge bg-success">Yes</span>
                                                    @else
                                                        <span class="badge bg-secondary">No</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button type="button"
                                                            class="btn btn-sm btn-primary editProductImage"
                                                            data-url="{{ route('admin.products.images.edit', [$product->id, $image->id]) }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    <form action="{{ route('admin.products.images.delete', [$product->id, $image->id]) }}"
                                                          method="POST"
                                                          style="display:inline-block;"
                                                          onsubmit="return confirm('Are you sure you want to delete this image?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">No records found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center mt-3">
                                    {{ $images->appends(request()->query())->links() }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            {{-- Edit Product Image Modal --}}
            <div class="modal fade" id="editProductImageModal" tabindex="-1" aria-labelledby="editProductImageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <form method="POST" enctype="multipart/form-data" id="editProductImageForm">
                        @csrf
                        @method('PUT')

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editProductImageModalLabel">Edit Product Image</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Product Image</label>
                                        <input type="file" name="image_path" class="form-control">

                                        <a href="#" target="_blank" id="editImageLink" class="d-inline-block mt-2">
                                            <img src=""
                                                 id="editImagePreview"
                                                 width="100"
                                                 height="100"
                                                 class="rounded border"
                                                 style="object-fit:cover;">
                                        </a>

                                        @if($errors->has('image_path'))
                                            <span class="text-danger">
                                                {{ $errors->first('image_path') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Alt Text</label>
                                        <input type="text"
                                               name="alt_text"
                                               id="edit_alt_text"
                                               class="form-control">

                                        @if($errors->has('alt_text'))
                                            <span class="text-danger">
                                                {{ $errors->first('alt_text') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Sort Order</label>
                                        <input type="number"
                                               name="sort_order"
                                               id="edit_sort_order"
                                               class="form-control">

                                        @if($errors->has('sort_order'))
                                            <span class="text-danger">
                                                {{ $errors->first('sort_order') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">
                                            Primary <span style="color:red;">*</span>
                                        </label>
                                        <select name="is_primary" id="edit_is_primary" class="form-control">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>

                                        @if($errors->has('is_primary'))
                                            <span class="text-danger">
                                                {{ $errors->first('is_primary') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $('#selectAll').on('click', function () {
        $('.rowCheckbox').prop('checked', this.checked);
    });

    $('.editProductImage').on('click', function () {
        let url = $(this).data('url');

        $.ajax({
            url: url,
            type: "GET",
            success: function (response) {
                if (response.status) {
                    $('#editProductImageForm').attr('action', response.update_url);
                    $('#edit_alt_text').val(response.data.alt_text);
                    $('#edit_sort_order').val(response.data.sort_order);
                    $('#edit_is_primary').val(response.data.is_primary);
                    $('#editImagePreview').attr('src', response.image_url);
                    $('#editImageLink').attr('href', response.image_url);
                    $('#editProductImageModal').modal('show');
                }
            }
        });
    });

    $('#bulkDelete').on('click', function () {
        let ids = [];

        $('.rowCheckbox:checked').each(function () {
            ids.push($(this).val());
        });

        if (ids.length === 0) {
            alert('Please select at least one record.');
            return false;
        }

        if (!confirm('Are you sure you want to delete selected images?')) {
            return false;
        }

        $.ajax({
            url: "{{ route('admin.products.images.bulkDelete', $product->id) }}",
            type: "POST",
            data: {
                ids: ids,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                alert(response.message);
                location.reload();
            }
        });
    });
</script>
@endsection
