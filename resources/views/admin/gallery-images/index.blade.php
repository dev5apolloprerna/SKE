@extends('layouts.app')

@section('title', 'Gallery Images')

@section('content')

<div class="main-content">
<div class="page-content">
<div class="container-fluid">

@include('common.alert')

<div class="row">
    <div class="col-12">
        <h4 class="mb-3">Gallery Images</h4>
    </div>
</div>

<div class="row">

    {{-- LEFT SIDE ADD --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5>Add Image</h5>
            </div>

            <div class="card-body">
                <form method="POST" enctype="multipart/form-data"
                      action="{{ route('admin.gallery-images.store') }}">
                    @csrf

                    {{-- TITLE --}}
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control"
                               value="{{ old('title') }}">
                        @if($errors->has('title'))
                            <span class="text-danger">
                                {{ $errors->first('title') }}
                            </span>
                        @endif
                    </div>

                    {{-- IMAGE --}}
                    <div class="mb-3">
                        <label>Image <span style="color:red;">*</span></label>
                        <input type="file" name="image_path" class="form-control">

                        @if($errors->has('image_path'))
                            <span class="text-danger">
                                {{ $errors->first('image_path') }}
                            </span>
                        @endif
                    </div>

                    {{-- DESCRIPTION --}}
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                        @if($errors->has('description'))
                            <span class="text-danger">
                                {{ $errors->first('description') }}
                            </span>
                        @endif
                    </div>

                    {{-- SORT --}}
                    <div class="mb-3">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order" class="form-control"
                               value="{{ old('sort_order', 0) }}">
                        @if($errors->has('sort_order'))
                            <span class="text-danger">
                                {{ $errors->first('sort_order') }}
                            </span>
                        @endif
                    </div>

                    {{-- STATUS --}}
                    <div class="mb-3">
                        <label>Status <span style="color:red;">*</span></label>
                        <select name="is_active" class="form-control">
                            <option value="1" {{ old('is_active', 1)==1?'selected':'' }}>Active</option>
                            <option value="0" {{ old('is_active', 1)==0?'selected':'' }}>Inactive</option>
                        </select>
                        @if($errors->has('is_active'))
                            <span class="text-danger">
                                {{ $errors->first('is_active') }}
                            </span>
                        @endif
                    </div>

                    <button class="btn btn-primary">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- RIGHT SIDE LIST --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5>Gallery List</h5>
            </div>

            <div class="card-body">

                {{-- SEARCH --}}
                <form method="GET" class="mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Search Title</label>
                            <input type="text" name="search" class="form-control"
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-6 mt-4">
                            <button class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="{{ route('admin.gallery-images.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>

                {{-- BULK DELETE --}}
                <button id="bulkDelete" class="btn btn-danger btn-sm mb-3">
                    <i class="fas fa-trash"></i> Bulk Delete
                </button>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Sort</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($galleryImages as $row)
                            <tr>
                                <td>
                                    <input type="checkbox" class="rowCheckbox" value="{{ $row->id }}">
                                </td>

                                <td>
                                    @if($row->image_url)
                                        <img src="{{ asset($row->image_url) }}"
                                             width="60" height="60"
                                             style="object-fit:cover;border-radius:6px;">
                                    @endif
                                </td>

                                <td>{{ $row->title }}</td>
                                <td>{{ $row->sort_order }}</td>

                                <td>
                                    @if($row->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>

                                <td>
                                    <button type="button"
                                            class="btn btn-sm btn-primary editBtn"
                                            data-id="{{ $row->id }}"
                                            data-title="{{ $row->title }}"
                                            data-description="{{ $row->description }}"
                                            data-sort_order="{{ $row->sort_order }}"
                                            data-is_active="{{ $row->is_active }}"
                                            data-image="{{ $row->image_url ? asset($row->image_url) : '' }}"
                                            data-action="{{ route('admin.gallery-images.update', $row->id) }}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <form method="POST"
                                          action="{{ route('admin.gallery-images.destroy',$row->id) }}"
                                          style="display:inline-block;"
                                          onsubmit="return confirm('Delete this record?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No Data</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    {{ $galleryImages->links() }}
                </div>

            </div>
        </div>
    </div>

</div>

{{-- EDIT MODAL --}}
<div class="modal fade" id="editGalleryImageModal" tabindex="-1" aria-labelledby="editGalleryImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" enctype="multipart/form-data" id="editGalleryImageForm">
            @csrf
            @method('PUT')

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGalleryImageModalLabel">Edit Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {{-- TITLE --}}
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="title" id="edit_title" class="form-control">
                        @if($errors->has('title'))
                            <span class="text-danger">
                                {{ $errors->first('title') }}
                            </span>
                        @endif
                    </div>

                    {{-- IMAGE --}}
                    <div class="mb-3">
                        <label>Image</label>
                        <input type="file" name="image_path" class="form-control">

                        <div id="edit_image_preview_wrap" class="mt-2" style="display:none;">
                            <img src="" id="edit_image_preview" width="80" class="rounded">
                        </div>

                        @if($errors->has('image_path'))
                            <span class="text-danger">
                                {{ $errors->first('image_path') }}
                            </span>
                        @endif
                    </div>

                    {{-- DESCRIPTION --}}
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" id="edit_description" class="form-control"></textarea>
                        @if($errors->has('description'))
                            <span class="text-danger">
                                {{ $errors->first('description') }}
                            </span>
                        @endif
                    </div>

                    {{-- SORT --}}
                    <div class="mb-3">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order" id="edit_sort_order" class="form-control">
                        @if($errors->has('sort_order'))
                            <span class="text-danger">
                                {{ $errors->first('sort_order') }}
                            </span>
                        @endif
                    </div>

                    {{-- STATUS --}}
                    <div class="mb-3">
                        <label>Status <span style="color:red;">*</span></label>
                        <select name="is_active" id="edit_is_active" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        @if($errors->has('is_active'))
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
$(document).on('click', '.editBtn', function(){
    $('#editGalleryImageForm').attr('action', $(this).data('action'));
    $('#edit_title').val($(this).data('title'));
    $('#edit_description').val($(this).data('description'));
    $('#edit_sort_order').val($(this).data('sort_order'));
    $('#edit_is_active').val($(this).data('is_active'));

    let imageUrl = $(this).data('image');

    if(imageUrl){
        $('#edit_image_preview').attr('src', imageUrl);
        $('#edit_image_preview_wrap').show();
    } else {
        $('#edit_image_preview').attr('src', '');
        $('#edit_image_preview_wrap').hide();
    }

    $('#editGalleryImageModal').modal('show');
});

$('#selectAll').click(function(){
    $('.rowCheckbox').prop('checked', this.checked);
});

$('#bulkDelete').click(function(){

    let ids = [];

    $('.rowCheckbox:checked').each(function(){
        ids.push($(this).val());
    });

    if(ids.length == 0){
        alert('Select at least one');
        return;
    }

    if(!confirm('Delete selected records?')) return;

    $.ajax({
        url: "{{ route('admin.gallery-images.bulkDelete') }}",
        type: "POST",
        data: {
            ids: ids,
            _token: "{{ csrf_token() }}"
        },
        success: function(res){
            location.reload();
        }
    });

});
</script>
@endsection
