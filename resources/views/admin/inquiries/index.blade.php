@extends('layouts.app')

@section('title', 'Inquiry List')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            @include('common.alert')

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-header">
                            <h5 class="card-title mb-0">Inquiry List</h5>
                        </div>

                        <div class="card-body">

                            <form method="GET" action="{{ route('admin.inquiries.index') }}" class="mb-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Search Inquiry</label>
                                        <input type="text"
                                               name="search"
                                               value="{{ request('search') }}"
                                               class="form-control"
                                               placeholder="Search by name, phone, email, product">
                                    </div>
                                    <div class="col-md-4 mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                        <a href="{{ route('admin.inquiries.index') }}" class="btn btn-secondary">
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
                                            <th>Product</th>
                                            <th>Model No</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Company</th>
                                            <th>Status</th>
                                            <th width="120">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($inquiries as $inquiry)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="rowCheckbox" value="{{ $inquiry->id }}">
                                                </td>
                                                <td>{{ $inquiry->product->name ?? '-' }}</td>
                                                <td>{{ $inquiry->product->model_no ?? '-' }}</td>
                                                <td>{{ $inquiry->name ?? '-' }}</td>
                                                <td>{{ $inquiry->phone }}</td>
                                                <td>{{ $inquiry->email ?? '-' }}</td>
                                                <td>{{ $inquiry->company_name ?? '-' }}</td>
                                                <td>
                                                    <span class="badge bg-info">
                                                        {{ ucfirst($inquiry->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.inquiries.edit', $inquiry->id) }}"
                                                       class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <form action="{{ route('admin.inquiries.destroy', $inquiry->id) }}"
                                                          method="POST"
                                                          style="display:inline-block;"
                                                          onsubmit="return confirm('Are you sure you want to delete this inquiry?');">
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
                                                <td colspan="9" class="text-center">No records found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center mt-3">
                                    {{ $inquiries->links() }}
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

        if (!confirm('Are you sure you want to delete selected inquiries?')) {
            return false;
        }

        $.ajax({
            url: "{{ route('admin.inquiries.bulkDelete') }}",
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