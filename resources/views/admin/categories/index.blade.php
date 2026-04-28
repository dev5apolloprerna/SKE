@extends('layouts.app')

@section('title', 'Category List')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            {{-- Alert Messages --}}
            @include('common.alert')

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                Category List
                                <a href="{{ route('admin.categories.create') }}" style="float: right;" class="btn btn-sm btn-primary">
                                    <i class="far fa-plus"></i> Add Category
                                </a>
                            </h5>
                        </div>

                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <button type="button" id="bulkDeleteBtn" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Bulk Delete
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <form method="GET" action="{{ route('admin.categories.index') }}" class="d-flex justify-content-end">
                                        <label class="form-label me-2 mt-1">Search Category</label>
                                        <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm me-2" style="max-width: 260px;" placeholder="Name / Description">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-secondary ms-1">
                                            <i class="fas fa-sync"></i>
                                        </a>
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th style="width:40px;">
                                                <input type="checkbox" id="selectAll">
                                            </th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Sort Order</th>
                                            <th>Status</th>
                                            <th>Created Date</th>
                                            <th style="width:120px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($categories as $category)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="rowCheckbox" value="{{ $category->slug }}">
                                                </td>
                                                <td>
                                                    @if($category->image_url)
                                                        <img src="{{ asset($category->image_url) }}" alt="{{ $category->name }}" width="60" height="45" style="object-fit:cover;">
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ Str::limit($category->description, 70) }}</td>
                                                <td>{{ $category->sort_order }}</td>
                                                <td>
                                                    <select class="form-select form-select-sm statusChange" data-slug="{{ $category->slug }}">
                                                        <option value="1" {{ $category->is_active == 1 ? 'selected' : '' }}>Active</option>
                                                        <option value="0" {{ $category->is_active == 0 ? 'selected' : '' }}>Inactive</option>
                                                    </select>
                                                </td>
                                                <td>{{ $category->created_at ? $category->created_at->format('d-m-Y') : '-' }}</td>
                                                <td>
                                                    <a href="{{ route('admin.categories.edit', $category->slug) }}" class="btn btn-sm btn-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger singleDelete" data-slug="{{ $category->slug }}" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">No records found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center mt-3">
                                    {{ $categories->links() }}
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

@section('script')
<script>
$(document).ready(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    });

    $('#selectAll').on('change', function () {
        $('.rowCheckbox').prop('checked', $(this).is(':checked'));
    });

    $('.singleDelete').on('click', function () {
        let slug = $(this).data('slug');

        if (!confirm('Are you sure you want to delete this record?')) {
            return false;
        }

        $.ajax({
            url: "{{ url('admin/categories') }}/" + slug,
            type: 'DELETE',
            success: function (response) {
                alert(response.message);
                location.reload();
            },
            error: function () {
                alert('Something went wrong.');
            }
        });
    });

    $('#bulkDeleteBtn').on('click', function () {
        let slugs = $('.rowCheckbox:checked').map(function () {
            return $(this).val();
        }).get();

        if (slugs.length === 0) {
            alert('Please select at least one record.');
            return false;
        }

        if (!confirm('Are you sure you want to delete selected records?')) {
            return false;
        }

        $.ajax({
            url: "{{ route('admin.categories.bulkDelete') }}",
            type: 'POST',
            data: { slugs: slugs },
            success: function (response) {
                alert(response.message);
                location.reload();
            },
            error: function () {
                alert('Something went wrong.');
            }
        });
    });

    $('.statusChange').on('change', function () {
        $.ajax({
            url: "{{ route('admin.categories.changeStatus') }}",
            type: 'POST',
            data: {
                slug: $(this).data('slug'),
                status: $(this).val()
            },
            success: function (response) {
                alert(response.message);
            },
            error: function () {
                alert('Something went wrong.');
                location.reload();
            }
        });
    });
});
</script>
@endsection
