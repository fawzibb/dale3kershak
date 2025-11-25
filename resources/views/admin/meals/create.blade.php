@extends('admin.layout')

@section('content')

<h2>Add New Meal</h2>

<form action="/admin/meals" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label class="form-label">Category</label>
        <select name="category_id" class="form-control" required>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Name</label>
        <input name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label>Price ($)</label>
        <input type="number" step="0.01" name="price" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Meal Image</label>
        <input type="file" name="image" class="form-control">
    </div>

    <button class="btn btn-success">Save</button>
</form>

@endsection
