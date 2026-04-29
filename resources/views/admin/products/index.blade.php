@extends('layouts.app')

@section('title', 'Product List')

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
                                Product List
                                <a href="{{ route('admin.products.create') }}" style="float:right;" class="btn btn-sm btn-primary">
                                    <i class="far fa-plus"></i> Add Product
                                </a>
                            </h5>
                        </div>

                        <div class="card-body">

                            <form method="GET" action="{{ route('admin.products.index') }}" class="mb-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Search Product</label>
                                        <input type="text" name="search" value="{{ request('search') }}"
                                               class="form-control"
                                               placeholder="Search by product, model, category">
                                    </div>
                                    <div class="col-md-4 mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Reset</a>
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
                                            <th>Model No</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Subcategory</th>
                                            <th>Size MM</th>
                                            <th>Featured</th>
                                            <th>Status</th>
                                            <th width="120">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($products as $product)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="rowCheckbox" value="{{ $product->slug }}">
                                                </td>
                                                <td>
                                                    @if($product->primaryImage)
                                                        <img src="{{ asset($product->primaryImage->image_path) }}"
                                                             width="60" height="60"
                                                             style="object-fit:cover;border-radius:6px;">
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $product->model_no }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->category->name ?? '-' }}</td>
                                                <td>{{ $product->subcategory->name ?? '-' }}</td>
                                                <td>
                                                    {{ $product->length_mm ?? '-' }} x
                                                    {{ $product->width_mm ?? '-' }} x
                                                    {{ $product->height_mm ?? '-' }}
                                                </td>
                                                <td>{{ $product->is_featured ? 'Yes' : 'No' }}</td>
                                                <td>
                                                    <form action="{{ route('admin.products.changeStatus', $product->slug) }}" method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-sm {{ $product->is_active ? 'btn-success' : 'btn-warning' }}">
                                                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.products.edit', $product->slug) }}"
                                                       class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('admin.products.images', $product->id) }}"
                                                       class="btn btn-sm btn-info"
                                                       title="Product Images">
                                                        <i class="fas fa-images"></i>
                                                    </a>

                                                    <form action="{{ route('admin.products.destroy', $product->slug) }}"
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
                                                <td colspan="10" class="text-center">No records found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center mt-3">
                                    {{ $products->links() }}
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
            url: "{{ route('admin.products.bulkDelete') }}",
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