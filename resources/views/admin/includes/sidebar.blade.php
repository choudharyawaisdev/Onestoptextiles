<!-- SIDEBAR -->
<aside class="app-sidebar sticky" id="sidebar">
    <div class="main-sidebar-header">
        <a href="" class="header-logo text-center">
            <img src="{{ asset('assets/images/cafe chinos logo.jpg') }}" alt="Get Well" width="90px">
        </a>
    </div>

    <div class="main-sidebar" id="sidebar-scroll">
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>

            <li class="slide__category"><span class="category-name">Main</span></li>

            <ul class="main-menu">

                <!-- Dashboard -->
                <li class="slide">
                    <a href="{{ url('admin/dashboard') }}" class="side-menu__item">
                        <i class="fa-solid fa-house side-menu__icon"></i>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>

                <!-- Orders Dropdown -->
                <li class="slide mt-2 has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="fa-solid fa-cart-flatbed side-menu__icon"></i>
                        <span class="side-menu__label">Orders</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>

                    <ul class="slide-menu">
                        <li>
                            <a href="{{ url('admin/orders/today') }}" class="slide-item">
                                Today Orders
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('admin/orders') }}" class="slide-item">
                                All Orders
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('admin/orders/cancelled') }}" class="slide-item">
                                Cancel Orders
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Products -->
                <li class="slide mt-2">
                    <a href="{{ url('admin/products') }}" class="side-menu__item">
                        <i class="fa-solid fa-box side-menu__icon"></i>
                        <span class="side-menu__label">Products</span>
                    </a>
                </li>

            </ul>

            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg>
            </div>
        </nav>
    </div>

</aside>