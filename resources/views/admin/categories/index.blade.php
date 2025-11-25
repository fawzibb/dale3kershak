@extends('admin.layout')

@section('content')
    <h2>Categories List</h2>

    <a href="/admin/categories/create" class="btn btn-primary mb-3">+ Add Category</a>

    <table class="table table-bordered table-hover">
        <tr class="bg-dark text-white">
            <th>ID</th>
            <th>Name</th>
            <th width="180px">Actions</th>
        </tr>

        @foreach ($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>
                <!-- Edit Button -->
                <a href="/admin/categories/{{ $category->id }}/edit" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>

                <!-- Delete Button -->
                <form action="/admin/categories/{{ $category->id }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
@endsection
