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

    {{-- LEFT SIDE ADD / EDIT --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5>{{ $editGalleryImage ? 'Edit Image' : 'Add Image' }}</h5>
            </div>

            <div class="card-body">

                <form method="POST" enctype="multipart/form-data"
                      action="{{ $editGalleryImage
                        ? route('admin.gallery-images.update',$editGalleryImage->id)
                        : route('admin.gallery-images.store') }}">
                    @csrf

                    @if($editGalleryImage)
                        @method('PUT')
                    @endif

                    {{-- TITLE --}}
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control"
                               value="{{ old('title',$editGalleryImage->title ?? '') }}">
                    </div>

                    {{-- IMAGE --}}
                    <div class="mb-3">
                        <label>Image <span style="color:red;">*</span></label>
                        <input type="file" name="image_path" class="form-control">

                        @if($editGalleryImage && $editGalleryImage->image_url)
                            <img src="{{ asset($editGalleryImage->image_url) }}"
                                 width="80" class="mt-2 rounded">
                        @endif

                        @if($errors->has('image_path'))
                            <span class="text-danger">
                                {{ $errors->first('image_path') }}
                            </span>
                        @endif
                    </div>

                    {{-- DESCRIPTION --}}
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control">{{ old('description',$editGalleryImage->description ?? '') }}</textarea>
                    </div>

                    {{-- SORT --}}
                    <div class="mb-3">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order" class="form-control"
                               value="{{ old('sort_order',$editGalleryImage->sort_order ?? 0) }}">
                    </div>

                    {{-- STATUS --}}
                    <div class="mb-3">
                        <label>Status <span style="color:red;">*</span></label>
                        <select name="is_active" class="form-control">
                            <option value="1" {{ old('is_active',$editGalleryImage->is_active ?? 1)==1?'selected':'' }}>Active</option>
                            <option value="0" {{ old('is_active',$editGalleryImage->is_active ?? 1)==0?'selected':'' }}>Inactive</option>
                        </select>
                    </div>

                    <button class="btn btn-primary">
                        {{ $editGalleryImage ? 'Update' : 'Submit' }}
                    </button>

                    @if($editGalleryImage)
                        <a href="{{ route('admin.gallery-images.index') }}" class="btn btn-secondary">Cancel</a>
                    @endif

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

                                {{-- IMAGE --}}
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
                                    <a href="{{ route('admin.gallery-images.edit',$row->id) }}"
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>

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

</div>
</div>
</div>

@endsection

@section('scripts')
<script>

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