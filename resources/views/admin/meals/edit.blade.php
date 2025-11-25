@extends('admin.layout')

@section('content')

<h2>Edit Meal</h2>

<form action="/admin/meals/{{ $meal->id }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Category</label>
        <select name="category_id" class="form-control">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $meal->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Name</label>
        <input name="name" class="form-control" value="{{ $meal->name }}" required>
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control">{{ $meal->description }}</textarea>
    </div>

    <div class="mb-3">
        <label>Price</label>
        <input type="number" step="0.01" name="price" class="form-control" value="{{ $meal->price }}" required>
    </div>

    <div class="mb-3">
        <label>Current Image</label><br>
        @if($meal->image)
            <img src="{{ asset('storage/'.$meal->image) }}" width="100" class="mb-2">
        @else
            <p class="text-muted">No Image</p>
        @endif

        <label>Change Image</label>
        <input type="file" name="image" class="form-control">
    </div>

    <button class="btn btn-success w-100">Update</button>
</form>

@endsection
