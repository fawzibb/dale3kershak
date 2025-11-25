<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dale3kershak</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lato&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #F8F4EC;
            font-family: 'Lato', sans-serif;
            min-height: 100vh;
            position: relative;
            padding-bottom: 75px; /* مساحة للفوتر */
        }

        h1, h2, h3 {
            font-family: 'Playfair Display', serif;
        }

        .navbar {
            background-color: #4B3F2F;
        }

        .navbar-brand, .nav-link {
            color: #F3EBD3 !important;
        }

        /* Footer ثابت */
        .sticky-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background:#111;
            padding: 10px 0;
            z-index: 9999;
            text-align: center;
        }

        /* شكل الأيقونات */
        .social-icon {
            font-size: 26px;
            margin: 0 15px;
            color: #fff;
            transition: 0.3s;
        }

        .social-icon:hover {
            color: #d4af37 !important;
            transform: scale(1.2);
        }

    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">Dale3kershak</a>

        @php
            $cart = session('cart', []);
            $cartCount = $cart ? array_sum(array_column($cart, 'quantity')) : 0;
        @endphp

        <a href="/cart" class="position-relative text-decoration-none" style="font-size:22px; color: white;">
            🛒
            @if($cartCount > 0)
                <span id="cart-badge"
                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                    style="font-size:12px;">
                    {{ $cartCount }}
                </span>
            @endif
        </a>
    </div>
</nav>

<div class="container my-4">
    @yield('content')
</div>

<!-- Sticky Footer -->
<footer class="sticky-footer"style= "background:#4B3F2F;">

    <!-- Social Icons -->
    <a href="https://www.instagram.com/dale3_kerchak?igsh=MTU2bHFqbWs0d243Mg%3D%3D&utm_source=qr" target="_blank" class="social-icon">
        <i class="fa-brands fa-instagram"></i>
    </a>

    <a href="http://www.tiktok.com/@dale3_kerchak" target="_blank" class="social-icon">
        <i class="fa-brands fa-tiktok"></i>
    </a>

    <a href="http://wa.me/96179158544" target="_blank" class="social-icon">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

    <p class="text-muted mt-1" style="font-size:11px;">© {{ date('Y') }} Dale3kershak</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

</body>
</html>
