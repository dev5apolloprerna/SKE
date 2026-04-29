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

                {{-- Add/Edit Left Side --}}
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ $editSubcategory ? 'Edit Subcategory' : 'Add Subcategory' }}</h5>
                        </div>
                        <div class="card-body">

                            <form method="POST"
                                  action="{{ $editSubcategory
                                    ? route('admin.categories.subcategories.update', [$category->id, $editSubcategory->id])
                                    : route('admin.categories.subcategories.store', $category->id) }}">
                                @csrf

                                @if($editSubcategory)
                                    @method('PUT')
                                @endif

                                <div class="mb-3">
                                    <label class="form-label">
                                        Subcategory Name <span style="color:red;">*</span>
                                    </label>
                                    <input type="text"
                                           name="name"
                                           class="form-control"
                                           value="{{ old('name', $editSubcategory->name ?? '') }}">

                                    @if($errors->has('name'))
                                        <span class="text-danger">
                                            {{ $errors->first('name') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description"
                                              class="form-control"
                                              rows="3">{{ old('description', $editSubcategory->description ?? '') }}</textarea>

                                    @if($errors->has('description'))
                                        <span class="text-danger">
                                            {{ $errors->first('description') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Sort Order</label>
                                    <input type="number"
                                           name="sort_order"
                                           class="form-control"
                                           value="{{ old('sort_order', $editSubcategory->sort_order ?? 0) }}">

                                    @if($errors->has('sort_order'))
                                        <span class="text-danger">
                                            {{ $errors->first('sort_order') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        Status <span style="color:red;">*</span>
                                    </label>
                                    <select name="is_active" class="form-control">
                                        <option value="1" {{ old('is_active', $editSubcategory->is_active ?? 1) == 1 ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0" {{ old('is_active', $editSubcategory->is_active ?? 1) == 0 ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>

                                    @if($errors->has('is_active'))
                                        <span class="text-danger">
                                            {{ $errors->first('is_active') }}
                                        </span>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    {{ $editSubcategory ? 'Update' : 'Submit' }}
                                </button>

                                @if($editSubcategory)
                                    <a href="{{ route('admin.categories.subcategories', $category->id) }}"
                                       class="btn btn-secondary">
                                        Cancel
                                    </a>
                                @endif
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

                            <form method="GET"
                                  action="{{ route('admin.categories.subcategories', $category->id) }}"
                                  class="mb-3">
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
                                        <a href="{{ route('admin.categories.subcategories', $category->id) }}"
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
                                                    <input type="checkbox"
                                                           class="rowCheckbox"
                                                           value="{{ $subcategory->id }}">
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
                                                    <a href="{{ route('admin.categories.subcategories.edit', [$category->id, $subcategory->id]) }}"
                                                       class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <form action="{{ route('admin.categories.subcategories.delete', [$category->id, $subcategory->id]) }}"
                                                          method="POST"
                                                          style="display:inline-block;"
                                                          onsubmit="return confirm('Are you sure you want to delete this record?');">
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

@endsection

@section('scripts')
<script>
    $('#selectAll').on('click', function () {
        $('.rowCheckbox').prop('checked', this.checked);
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
</script>
@endsection