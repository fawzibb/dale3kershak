@extends('layout')

@php
    use App\Models\Setting;
    $rate = Setting::first()->exchange_rate ?? 90000;
@endphp

@section('content')

<h2 class="text-center mb-4" style="font-family:Playfair Display, serif;">🛒 Your Cart</h2>

@if(session('error'))
    <div class="alert alert-warning text-center">
        {{ session('error') }}
    </div>
@endif

@if(count($cart) > 0)

<!-- Desktop Table -->
<div class="d-none d-md-block">
<table class="table table-hover align-middle shadow-sm bg-white rounded">

    <thead class="table-dark">
        <tr>
            <th>Meal</th>
            <th>Category</th>
            <th width="120px">Quantity</th>
            <th>Price</th>
            <th>Total</th>
            <th width="50px"></th>
        </tr>
    </thead>

    <tbody>
        @foreach ($cart as $id => $item)
        <tr>
            <td>{{ $item['name'] }}</td>
            <td>{{ $item['category'] }}</td>

            <td>
                <input type="number" class="form-control quantity-input"
                       data-id="{{ $id }}" value="{{ $item['quantity'] }}" 
                       min="1">
            </td>

            <td>
                ${{ $item['price'] }} <br>
                <small class="text-muted">{{ number_format($item['price'] * $rate) }} L.L</small>
            </td>

            <td id="item-total-{{ $id }}">
                <strong class="item-usd">${{ $item['price'] * $item['quantity'] }}</strong>
                <br>
                <small id="item-total-ll-{{ $id }}" class="text-muted">
                    {{ number_format(($item['price'] * $item['quantity']) * $rate) }} L.L
                </small>
            </td>

            <td>
                <form action="/cart/remove/{{ $id }}" method="POST">
                    @csrf
                    <button class="btn btn-danger btn-sm">✕</button>
                </form>
            </td>
        </tr>
        @endforeach

        <tr class="fw-bold">
            <td colspan="4" class="text-end">Total:</td>
            <td id="cart-total">
                <span class="total-usd">
                    ${{ array_sum(array_map(fn($i)=>$i['price'] * $i['quantity'], $cart)) }}
                </span>
                <br>
                <small id="cart-total-ll" class="text-muted">
                    {{ number_format(array_sum(array_map(fn($i)=>$i['price'] * $i['quantity'], $cart)) * $rate) }} L.L
                </small>
            </td>
        </tr>
    </tbody>
</table>
</div>


<!-- Mobile Card View -->
<div class="d-md-none">
    @foreach($cart as $id => $item)
    <div class="card mb-3 shadow-sm">
        <div class="card-body">

            <h5 class="fw-bold">{{ $item['name'] }}</h5>
            <p class="text-muted mb-1">{{ $item['category'] }}</p>

            <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="fw-bold mb-0">Qty:</label>
                <input type="number" class="form-control quantity-input" 
                       style="width:90px;"
                       data-id="{{ $id }}" value="{{ $item['quantity'] }}" min="1">
            </div>

            <p class="mb-1">Price: ${{ $item['price'] }} 
                <br><small class="text-muted">{{ number_format($item['price'] * $rate) }} L.L</small>
            </p>

            <p class="fw-bold mb-2" id="item-total-{{ $id }}">
                Total: <span class="item-usd">${{ $item['price'] * $item['quantity'] }}</span>
                <br><small id="item-total-ll-{{ $id }}" class="text-muted">
                    {{ number_format(($item['price'] * $item['quantity']) * $rate) }} L.L
                </small>
            </p>

            <form action="/cart/remove/{{ $id }}" method="POST">
                @csrf
                <button class="btn btn-danger btn-sm w-100">Remove</button>
            </form>

        </div>
    </div>
    @endforeach


    <!-- Mobile Total -->
    <div class="card p-3 text-center fw-bold" style="background:#f7f1e3;">
        <span id="cart-total-mobile">
            Total: ${{ array_sum(array_map(fn($i)=>$i['price'] * $i['quantity'], $cart)) }}
        </span>
        <br>
        <small class="text-muted" id="cart-total-ll-mobile">
            {{ number_format(array_sum(array_map(fn($i)=>$i['price'] * $i['quantity'], $cart)) * $rate) }} L.L
        </small>
    </div>
</div>

<a href="/checkout" class="btn btn-success w-100 mt-4">Proceed to Checkout</a>

@else
<p class="text-muted text-center">Your cart is empty.</p>
@endif

@endsection


@push('scripts')
<script>
document.querySelectorAll('.quantity-input').forEach(input => {

    input.addEventListener('input', function () {

        const id = this.dataset.id;
        const quantity = this.value;

        fetch(`/cart/update-ajax/${id}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ quantity })
            
        })
        .then(res => res.json())
        .then(data => {

            if (!data.success) return;

            // تحديث سعر الصنف (في كل مكان موجود فيه العنصر)
            document.querySelectorAll(`#item-total-${id} .item-usd`).forEach(el => {
                el.innerText = `$${data.item_total}`;
            });

            document.querySelectorAll(`#item-total-ll-${id}`).forEach(el => {
                el.innerText = `${data.item_total_ll} L.L`;
            });

            // تحديث الإجمالي (Desktop)
            const totalUsd = document.querySelector("#cart-total .total-usd");
            if (totalUsd) totalUsd.innerText = `$${data.cart_total}`;

            const totalLL = document.querySelector("#cart-total-ll");
            if (totalLL) totalLL.innerText = `${data.cart_total_ll} L.L`;

            // تحديث الإجمالي (Mobile)
            const mobileTotal = document.getElementById("cart-total-mobile");
            if (mobileTotal) mobileTotal.innerText = `Total: $${data.cart_total}`;

            const mobileTotalLL = document.getElementById("cart-total-ll-mobile");
            if (mobileTotalLL) mobileTotalLL.innerText = `${data.cart_total_ll} L.L`;

            // تحديث عداد السلة
            const badge = document.getElementById("cart-badge");
            if (badge) badge.innerText = data.cart_count;
        });

    });
});
</script>

@endpush
