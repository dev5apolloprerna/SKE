@extends('layouts.app')

@section('title', 'Subcategory List')

@section('content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            @include('common.alert')

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                Subcategory List
                                <a href="{{ route('admin.subcategories.create') }}"
                                   style="float:right;"
                                   class="btn btn-sm btn-primary">
                                    <i class="far fa-plus"></i> Add Subcategory
                                </a>
                            </h5>
                        </div>

                        <div class="card-body">

                            <form method="GET" action="{{ route('admin.subcategories.index') }}" class="mb-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Search Subcategory</label>
                                        <input type="text"
                                               name="search"
                                               value="{{ request('search') }}"
                                               class="form-control"
                                               placeholder="Search by subcategory name">
                                    </div>
                                    <div class="col-md-4 mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                        <a href="{{ route('admin.subcategories.index') }}" class="btn btn-secondary">
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
                                            <th>
                                                <input type="checkbox" id="selectAll">
                                            </th>
                                            <th>Category</th>
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
                                                           value="{{ $subcategory->slug }}">
                                                </td>
                                                <td>{{ $subcategory->category->name ?? '-' }}</td>
                                                <td>{{ $subcategory->name }}</td>
                                                <td>{{ Str::limit($subcategory->description, 60) }}</td>
                                                <td>{{ $subcategory->sort_order }}</td>
                                                <td>
                                                    <form action="{{ route('admin.subcategories.changeStatus', $subcategory->slug) }}"
                                                          method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                                class="btn btn-sm {{ $subcategory->is_active ? 'btn-success' : 'btn-warning' }}">
                                                            {{ $subcategory->is_active ? 'Active' : 'Inactive' }}
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.subcategories.edit', $subcategory->slug) }}"
                                                       class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <form action="{{ route('admin.subcategories.destroy', $subcategory->slug) }}"
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
                                                <td colspan="7" class="text-center">No records found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center mt-3">
                                    {{ $subcategories->links() }}
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
            url: "{{ route('admin.subcategories.bulkDelete') }}",
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