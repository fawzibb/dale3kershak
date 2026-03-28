@extends('admin.layout')

@section('content')
<h2>Edit Category</h2>

<form action="/admin/categories/{{ $category->id }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Name:</label>
        <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
    </div>
          <!-- Coming Soon -->
    <div class="mb-3 form-check">
    <input type="checkbox" name="coming_soon" value="1" class="form-check-input" id="comingSoon"
           {{ $category->coming_soon ? 'checked' : '' }}>
    <label class="form-check-label" for="comingSoon">Coming Soon</label>
</div>

    <button class="btn btn-success">Update</button>
</form>
@endsection
