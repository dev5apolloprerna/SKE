@extends('layouts.app')

@section('title', 'Product Image List')

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
                                Product Image List
                                <a href="{{ route('admin.product-images.create') }}"
                                   style="float:right;"
                                   class="btn btn-sm btn-primary">
                                    <i class="far fa-plus"></i> Add Product Image
                                </a>
                            </h5>
                        </div>

                        <div class="card-body">

                            <form method="GET" action="{{ route('admin.product-images.index') }}" class="mb-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Search Product</label>
                                        <input type="text"
                                               name="search"
                                               value="{{ request('search') }}"
                                               class="form-control"
                                               placeholder="Search by product or model no">
                                    </div>
                                    <div class="col-md-4 mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                        <a href="{{ route('admin.product-images.index') }}" class="btn btn-secondary">
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
                                            <th>Product</th>
                                            <th>Model No</th>
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
                                                    <input type="checkbox" class="rowCheckbox" value="{{ $image->id }}">
                                                </td>
                                                <td>
                                                    <img src="{{ asset($image->image_path) }}"
                                                         width="70"
                                                         height="70"
                                                         style="object-fit:cover;border-radius:6px;">
                                                </td>
                                                <td>{{ $image->product->name ?? '-' }}</td>
                                                <td>{{ $image->product->model_no ?? '-' }}</td>
                                                <td>{{ $image->alt_text ?? '-' }}</td>
                                                <td>{{ $image->sort_order }}</td>
                                                <td>
                                                    @if($image->is_primary)
                                                        <span class="badge bg-success">Yes</span>
                                                    @else
                                                        <span class="badge bg-secondary">No</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.product-images.edit', $image->id) }}"
                                                       class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <form action="{{ route('admin.product-images.destroy', $image->id) }}"
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
                                                <td colspan="8" class="text-center">No records found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center mt-3">
                                    {{ $images->links() }}
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
            url: "{{ route('admin.product-images.bulkDelete') }}",
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