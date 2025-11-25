@extends('admin.layout')

@section('content')

<h2>Exchange Rate Settings</h2>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('settings.update') }}" method="POST">
    @csrf
    
    <div class="mb-3">
        <label>Exchange Rate (1 USD → L.L)</label>
        <input type="number" name="exchange_rate" value="{{ $setting->exchange_rate }}" class="form-control" required>
    </div>

    <button class="btn btn-primary">Update</button>
</form>

@endsection
