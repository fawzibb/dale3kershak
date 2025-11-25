@extends('admin.layout')

@section('content')

@php
    use App\Models\Setting;
    $rate = Setting::first()->exchange_rate ?? 90000;
@endphp

<h2 class="mb-3">Admin Dashboard</h2>
<p class="text-muted">Manage categories, meals, menu, and settings.</p>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Exchange Rate Card -->
<div class="card shadow-sm mb-4" style="max-width:400px;">
    <div class="card-body">

        <h5 class="card-title">💵 Exchange Rate</h5>

        <p class="mb-2">
            <strong>Current Rate:</strong>
            <span class="badge bg-dark fs-6">
                {{ number_format($rate, 0, ',', '.') }} L.L / $
            </span>
        </p>

        <!-- Update Form -->
        <form action="{{ route('admin.updateRate') }}" method="POST" class="mt-3">
            @csrf
            <label class="form-label">Update Rate</label>
            <input type="text" id="rateInput" name="exchange_rate" 
                   value="{{ number_format($rate, 0, ',', '.') }}" 
                   class="form-control" required>

            <button class="btn btn-primary mt-3 w-100">
                Save New Rate
            </button>
        </form>

    </div>
</div>

@endsection


@push('scripts')
<script>
document.querySelector("form").addEventListener("submit", function() {
    let input = document.getElementById("rateInput");
    input.value = input.value.replace(/\./g, ""); // remove dots before saving
});
</script>
@endpush
