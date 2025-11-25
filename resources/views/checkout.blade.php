@extends('layout')

@section('content')

<h2>Checkout</h2>

<form action="/order" method="POST">
    @csrf

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="customer_name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="phone" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Address</label>
        <textarea name="address" class="form-control" required></textarea>
    </div>

    <button class="btn btn-dark w-100">Confirm Order</button>
</form>

@endsection
