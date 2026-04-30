@extends('layouts.app')

@section('title', 'Manage Subcategories')

@section('content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            @include('common.alert')

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Manage Subcategories - {{ $category->name }}</h4>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">

                {{-- Add Left Side --}}
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Add Subcategory</h5>
                        </div>
                        <div class="card-body">

                            <form method="POST" action="{{ route('admin.categories.subcategories.store', $category->id) }}">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Subcategory Name <span style="color:red;">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">

                                    @if($errors->has('name') && !old('_method'))
                                        <span class="text-danger">
                                            {{ $errors->first('name') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>

                                    @if($errors->has('description') && !old('_method'))
                                        <span class="text-danger">
                                            {{ $errors->first('description') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Sort Order</label>
                                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">

                                    @if($errors->has('sort_order') && !old('_method'))
                                        <span class="text-danger">
                                            {{ $errors->first('sort_order') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Status <span style="color:red;">*</span></label>
                                    <select name="is_active" class="form-control">
                                        <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('is_active', 1) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>

                                    @if($errors->has('is_active') && !old('_method'))
                                        <span class="text-danger">
                                            {{ $errors->first('is_active') }}
                                        </span>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>

                        </div>
                    </div>
                </div>

                {{-- Listing Right Side --}}
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Subcategory List</h5>
                        </div>

                        <div class="card-body">

                            <form method="GET" action="{{ route('admin.categories.subcategories', $category->id) }}" class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Search Subcategory</label>
                                        <input type="text"
                                               name="search"
                                               value="{{ request('search') }}"
                                               class="form-control"
                                               placeholder="Search by subcategory name">
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                        <a href="{{ route('admin.categories.subcategories', $category->id) }}" class="btn btn-secondary">
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
                                            <th>Subcategory Name</th>
                                            <th>Description</th>
                                            <th>Sort Order</th>
                                            <th>Status</th>
                                            <th width="120">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($subcategories as $subcategory)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="rowCheckbox" value="{{ $subcategory->id }}">
                                                </td>
                                                <td>{{ $subcategory->name }}</td>
                                                <td>{{ Str::limit($subcategory->description, 50) }}</td>
                                                <td>{{ $subcategory->sort_order }}</td>
                                                <td>
                                                    @if($subcategory->is_active == 1)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-warning">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button type="button"
                                                            class="btn btn-sm btn-primary editSubcategory"
                                                            data-id="{{ $subcategory->id }}"
                                                            data-name="{{ $subcategory->name }}"
                                                            data-description="{{ $subcategory->description }}"
                                                            data-sort_order="{{ $subcategory->sort_order }}"
                                                            data-is_active="{{ $subcategory->is_active }}"
                                                            data-update-url="{{ route('admin.categories.subcategories.update', [$category->id, $subcategory->id]) }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    <button type="button"
                                                            class="btn btn-sm btn-danger deleteSubcategory"
                                                            data-url="{{ route('admin.categories.subcategories.delete', [$category->id, $subcategory->id]) }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No records found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center mt-3">
                                    {{ $subcategories->appends(request()->query())->links() }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editSubcategoryModal" tabindex="-1" aria-labelledby="editSubcategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" id="editSubcategoryForm" action="">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="editSubcategoryModalLabel">Edit Subcategory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Subcategory Name <span style="color:red;">*</span></label>
                        <input type="text" name="name" id="edit_name" class="form-control" value="{{ old('_method') ? old('name') : '' }}">

                        @if($errors->has('name') && old('_method'))
                            <span class="text-danger">
                                {{ $errors->first('name') }}
                            </span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="3">{{ old('_method') ? old('description') : '' }}</textarea>

                        @if($errors->has('description') && old('_method'))
                            <span class="text-danger">
                                {{ $errors->first('description') }}
                            </span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" id="edit_sort_order" class="form-control" value="{{ old('_method') ? old('sort_order') : '' }}">

                        @if($errors->has('sort_order') && old('_method'))
                            <span class="text-danger">
                                {{ $errors->first('sort_order') }}
                            </span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status <span style="color:red;">*</span></label>
                        <select name="is_active" id="edit_is_active" class="form-control">
                            <option value="1" {{ old('_method') && old('is_active') == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('_method') && old('is_active') == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>

                        @if($errors->has('is_active') && old('_method'))
                            <span class="text-danger">
                                {{ $errors->first('is_active') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $('#selectAll').on('click', function () {
        $('.rowCheckbox').prop('checked', this.checked);
    });

    $('.editSubcategory').on('click', function () {
        $('#editSubcategoryForm').attr('action', $(this).data('update-url'));
        $('#edit_name').val($(this).data('name'));
        $('#edit_description').val($(this).data('description'));
        $('#edit_sort_order').val($(this).data('sort_order'));
        $('#edit_is_active').val($(this).data('is_active'));

        $('#editSubcategoryModal').modal('show');
    });

    $('.deleteSubcategory').on('click', function () {
        if (!confirm('Are you sure you want to delete this record?')) {
            return false;
        }

        $.ajax({
            url: $(this).data('url'),
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                _method: "DELETE"
            },
            success: function (response) {
                alert(response.message);
                location.reload();
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

        if (!confirm('Are you sure you want to delete selected records?')) {
            return false;
        }

        $.ajax({
            url: "{{ route('admin.categories.subcategories.bulkDelete', $category->id) }}",
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

    @if($errors->any() && old('_method'))
        $('#editSubcategoryModal').modal('show');
    @endif
</script>
@endsection
