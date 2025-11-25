@extends('admin.layout')

@section('content')

<h2 class="mb-4">Meals</h2>

<a href="/admin/meals/create" class="btn btn-primary mb-3">+ Add Meal</a>

<!-- 🔍 Search Box -->
<input type="text" id="mealSearch" class="form-control mb-3" placeholder="Search meals...">

<!-- Desktop Table -->
<div class="table-responsive d-none d-md-block">
<table class="table table-striped table-hover align-middle shadow-sm bg-white rounded" id="mealTable">

    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Status</th>
            <th>Image</th>
            <th width="220px">Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($meals as $meal)
        <tr>
            <td>{{ $meal->id }}</td>
            <td>{{ $meal->name }}</td>
            <td>{{ $meal->category->name }}</td>
            <td>${{ $meal->price }}</td>

            <td>
                @if($meal->is_available)
                    <span class="badge bg-success">Available</span>
                @else
                    <span class="badge bg-danger">Out of Stock</span>
                @endif
            </td>

            <td>
                @if($meal->image)
                    <img src="{{ asset('storage/'.$meal->image) }}" width="60" class="rounded shadow-sm">
                @else
                    <span class="text-muted">No Image</span>
                @endif
            </td>

            <td>
                <a href="/admin/meals/{{ $meal->id }}/edit" class="btn btn-warning btn-sm mb-1">Edit</a>

                <form action="/admin/meals/{{ $meal->id }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm mb-1">Delete</button>
                </form>

                <form action="{{ route('meals.toggle', $meal->id) }}" method="POST" style="display:inline;">
                    @csrf @method('PATCH')
                    <button class="btn btn-{{ $meal->is_available ? 'secondary' : 'success' }} btn-sm mb-1">
                        {{ $meal->is_available ? 'Out of Stock' : 'In Stock' }}
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

<!-- 📱 Mobile Card View -->
<div class="d-md-none" id="mealCards">
@foreach($meals as $meal)
<div class="card mb-3 meal-card shadow-sm">
    <div class="card-body">

        <div class="d-flex justify-content-between">
            <h5 class="fw-bold meal-name">{{ $meal->name }}</h5>
            <span class="badge {{ $meal->is_available ? 'bg-success' : 'bg-danger' }}">
                {{ $meal->is_available ? 'Available' : 'Out Stock' }}
            </span>
        </div>

        <p class="text-muted meal-category mb-1">{{ $meal->category->name }}</p>
        <p class="fw-bold mb-2 meal-price">${{ $meal->price }}</p>

        @if($meal->image)
            <img src="{{ asset('storage/'.$meal->image) }}" class="rounded w-100 mb-3" style="max-height:160px; object-fit:cover;">
        @endif

        <div class="d-grid gap-2">
            <a href="/admin/meals/{{ $meal->id }}/edit" class="btn btn-warning btn-sm">Edit</a>

            <form action="/admin/meals/{{ $meal->id }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">Delete</button>
            </form>

            <form action="{{ route('meals.toggle', $meal->id) }}" method="POST">
                @csrf @method('PATCH')
                <button class="btn btn-{{ $meal->is_available ? 'secondary' : 'success' }} btn-sm">
                    {{ $meal->is_available ? 'Mark Out of Stock' : 'Mark Available' }}
                </button>
            </form>

        </div>
    </div>
</div>
@endforeach
</div>

@endsection


@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {

    const searchInput = document.getElementById('mealSearch');
    if (!searchInput) return;

    searchInput.addEventListener('input', function() {

        const term = this.value.toLowerCase().trim();

        // ----- Desktop Table Filter -----
        const rows = document.querySelectorAll('#mealTable tbody tr');
        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(term) ? "" : "none";
        });

        // ----- Mobile Card Filter -----
        const cards = document.querySelectorAll('.meal-card');
        cards.forEach(card => {
            const name = card.querySelector('.meal-name')?.innerText.toLowerCase() || "";
            const category = card.querySelector('.meal-category')?.innerText.toLowerCase() || "";
            const price = card.querySelector('.meal-price')?.innerText.toLowerCase() || "";

            card.style.display = (name.includes(term) || category.includes(term) || price.includes(term))
                ? "" : "none";
        });

    });

});
</script>
@endpush
