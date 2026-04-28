@extends('layouts.app')

@section('title', 'Edit Inquiry')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            @include('common.alert')

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Edit Inquiry</h4>
                        <div class="page-title-right">
                            <a href="{{ route('admin.inquiries.index') }}"
                               class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.inquiries.update', $inquiry->id) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Product</label>
                                        <input type="text"
                                               class="form-control"
                                               value="{{ $inquiry->product->name ?? '-' }}"
                                               readonly>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Model No</label>
                                        <input type="text"
                                               class="form-control"
                                               value="{{ $inquiry->product->model_no ?? '-' }}"
                                               readonly>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Name</label>
                                        <input type="text"
                                               class="form-control"
                                               value="{{ $inquiry->name ?? '-' }}"
                                               readonly>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Phone</label>
                                        <input type="text"
                                               class="form-control"
                                               value="{{ $inquiry->phone }}"
                                               readonly>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Email</label>
                                        <input type="text"
                                               class="form-control"
                                               value="{{ $inquiry->email ?? '-' }}"
                                               readonly>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Company Name</label>
                                        <input type="text"
                                               class="form-control"
                                               value="{{ $inquiry->company_name ?? '-' }}"
                                               readonly>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <label class="form-label">Message</label>
                                        <textarea class="form-control" rows="4" readonly>{{ $inquiry->message }}</textarea>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">
                                            Status <span style="color:red;">*</span>
                                        </label>
                                        <select name="status" class="form-control">
                                            <option value="new" {{ old('status', $inquiry->status) == 'new' ? 'selected' : '' }}>New</option>
                                            <option value="contacted" {{ old('status', $inquiry->status) == 'contacted' ? 'selected' : '' }}>Contacted</option>
                                            <option value="quoted" {{ old('status', $inquiry->status) == 'quoted' ? 'selected' : '' }}>Quoted</option>
                                            <option value="closed" {{ old('status', $inquiry->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                                            <option value="spam" {{ old('status', $inquiry->status) == 'spam' ? 'selected' : '' }}>Spam</option>
                                        </select>
                                        @if($errors->has('status'))
                                            <span class="text-danger">
                                                {{ $errors->first('status') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">
                                            Update Status
                                        </button>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection