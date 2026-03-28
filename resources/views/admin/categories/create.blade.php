@extends('admin.layout')

@section('content')

<h2>Add New Category</h2>

<form action="/admin/categories" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label class="form-label">Category Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
      <!-- Coming Soon -->
    <div class="mb-3 form-check">
        <input type="checkbox" name="coming_soon" value="1" class="form-check-input" id="comingSoon">
        <label class="form-check-label" for="comingSoon">Coming Soon</label>
    </div>


    <button class="btn btn-success">Save</button>
</form>

@endsection
