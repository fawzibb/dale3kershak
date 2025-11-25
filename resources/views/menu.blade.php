@extends('layout')

@section('content')

<style>
    .menu-title {
        font-family: 'Playfair Display', serif;
        text-align: center;
        font-size: 40px;
        margin-bottom: 20px;
        color: #4B3F2F;
    }
    .category-btn {
        font-family: 'Playfair Display', serif;
        font-size: 20px;
        margin: 5px;
        border-radius: 20px;
    }
    .meal-card {
        border-radius: 15px;
        overflow: hidden;
        transition: 0.3s;
    }
    .meal-card:hover {
        transform: scale(1.03);
    }
    .meal-img {
    width: 100%;
    height: 300px; /* يمكنك تعديل الرقم */
    object-fit: cover;
    border-radius: 20px;
}
.out-stock {
    opacity: 0.45;
    filter: grayscale(100%) blur(1px);
    pointer-events: none;
}

.out-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(150, 0, 0, 0.85);
    color: #fff;
    padding: 8px 18px;
    border-radius: 8px;
    font-weight: bold;
    font-size: 16px;
    z-index: 10;
    pointer-events: none;
}

.meal-card {
    position: relative;
    overflow: hidden;
}


</style>


<h1 class="menu-title">Our Menu</h1>


<!-- Category Navigation -->
<div class="d-flex justify-content-center mb-4 flex-wrap">
@foreach($categories as $category)
    <button class="btn btn-outline-dark category-btn" data-category="{{ $category->id }}">
        {{ $category->name }}
    </button>
@endforeach
</div>

<hr>

<!-- Meals List -->
@foreach($categories as $category)
<div class="meal-section" id="category-{{ $category->id }}" style="display: none;">
    
    <h2 class="text-center" style="font-family:'Playfair Display', serif; color:#704F38;">
        {{ $category->name }}
    </h2>

    <div class="row mt-4">
        @foreach($category->meals->sortByDesc('is_available') as $meal)
        <div class="col-md-4 mb-4">
            
            <div class="card meal-card shadow position-relative {{ !$meal->is_available ? 'out-stock' : '' }}">
                
                <img src="{{ asset('storage/'.$meal->image) }}" class="meal-img" alt="{{ $meal->name }}">
                
                @if(!$meal->is_available)
                <span class="out-overlay">Out of Stock</span>
                @endif

                <div class="card-body">
                    <h5>{{ $meal->name }}</h5>
                    <p class="text-muted">{{ $meal->description }}</p>

                    <p class="fw-bold">${{ $meal->price }}</p>
                    <p class="text-muted" style="font-size:14px;">
                        L.L {{ number_format($meal->price_ll) }}
                    </p>

                    @if($meal->is_available)
                        <button 
                            class="btn btn-dark w-100 add-to-cart" 
                            data-id="{{ $meal->id }}">
                            Add to Cart 🛒
                        </button>
                    @else
                        <button class="btn btn-secondary w-100" disabled>
                            Out of Stock ❌
                        </button>
                    @endif
                </div>
                
            </div>
        </div>
        @endforeach
    </div>

</div>
@endforeach



<!-- Script -->
<script>
    let buttons = document.querySelectorAll('.category-btn');
    let sections = document.querySelectorAll('.meal-section');

    // Show first category by default
    if(sections.length > 0){
        sections[0].style.display = 'block';
    }

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            let id = btn.getAttribute('data-category');

            sections.forEach(sec => sec.style.display = 'none');

            document.getElementById('category-' + id).style.display = 'block';
        });
    });
</script>




@endsection
@push('scripts')
<script>
document.querySelectorAll('.add-to-cart').forEach(btn => {
    btn.addEventListener('click', function () {

        const id = this.dataset.id;

        fetch("/cart/add-ajax", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ id })
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success) return;

            // تحديث العدّاد في navbar
            const badge = document.getElementById("cart-badge");
            if (badge) {
                badge.innerText = data.cart_count;
            } else {
                // لو badge غير موجود ينشأ واحد جديد
                const cartIcon = document.querySelector('a[href="/cart"]');
                cartIcon.insertAdjacentHTML("beforeend", `
                    <span id="cart-badge" 
                          class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                          ${data.cart_count}
                    </span>
                `);
            }

            // إشعار بسيط (Toast)
            showToast("Item added to cart!");
        });
    });
});

// Toast notification function
function showToast(message) {
    const toast = document.createElement('div');
    toast.innerText = message;
    toast.style.position = "fixed";
    toast.style.bottom = "20px";
    toast.style.right = "20px";
    toast.style.padding = "10px 15px";
    toast.style.color = "#fff";
    toast.style.background = "#28a745";
    toast.style.borderRadius = "6px";
    toast.style.zIndex = 2000;
    toast.style.transition = "0.4s";
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = "0";
        setTimeout(() => toast.remove(), 400);
    }, 1500);
}
</script>
@endpush