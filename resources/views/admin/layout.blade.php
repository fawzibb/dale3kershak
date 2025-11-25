<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Dashboard</title>

    <!-- AdminLTE + Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">

        <!-- زر لإظهار القائمة على الهاتف -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <span class="navbar-brand ml-2">Restaurant Admin</span>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="/admin" class="brand-link text-center">
            <span class="brand-text font-weight-light">Dashboard</span>
        </a>

        <div class="sidebar">
            <nav>
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">
                    <li class="nav-item">
                        <a href="/admin/categories" class="nav-link">
                            <i class="fas fa-list"></i>
                            <p>Categories</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/admin/meals" class="nav-link">
                            <i class="fas fa-utensils"></i>
                            <p>Meals</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/" class="nav-link">
                            <i class="fas fa-shopping-cart"></i>
                            <p>Menu</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content -->
    <div class="content-wrapper p-3">
        @yield('content')
    </div>

</div>

    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>

    <!-- Bootstrap 4 Bundle (مع Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AdminLTE -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    @stack('scripts')

</body>
</html>

