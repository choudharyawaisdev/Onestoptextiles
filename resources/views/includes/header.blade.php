<header class="main-header sticky-top">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-2 d-lg-none">
                <button class="navbar-toggler p-0 border-0" type="button" data-toggle="collapse" data-target="#mainNav">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <div class="col-8 col-lg-3 text-center text-lg-left">
                <a href="#" class="logo">LUXE<span>THREAD</span></a>
            </div>

            <div class="col-lg-6 d-none d-lg-block">
                <div class="search-container">
                    <input type="text" class="form-control search-bar" placeholder="Search for premium clothing...">
                    <button class="btn-search-icon"><i class="fa fa-search"></i></button>
                </div>
            </div>

            <div class="col-2 col-lg-3 text-right header-icons">
                <a href="#" class="d-none d-md-inline-block"><i class="far fa-user"></i></a>
                <a href="#"><i class="far fa-heart"></i></a>
                <a href="#">
                    <i class="fas fa-shopping-bag"></i>
                    <span class="cart-badge" id="cart-count">0</span>
                </a>
            </div>
        </div>

        <div class="row d-lg-none mt-3 px-3">
            <div class="col-12">
                <div class="search-container">
                    <input type="text" class="form-control search-bar" placeholder="Search styles...">
                    <button class="btn-search-icon"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg p-0">
            <div class="collapse navbar-collapse justify-content-center" id="mainNav">
                <ul class="navbar-nav mt-3 mt-lg-2">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">New Arrivals</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Collections</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Return Policy</a></li>
                    <li class="nav-item d-lg-none"><a class="nav-link" href="#">Account</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <style>
        /* Navbar link base style */
        .navbar .nav-link {
            padding: 10px 18px;
            border-radius: 4px;
            color: #000;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Active & hover state */
        .navbar .nav-link.active,
        .navbar .nav-link:focus,
        .navbar .nav-link:hover {
            background-color: #0d6efd;
            /* Blue */
            color: #fff !important;
        }
    </style>
</header>