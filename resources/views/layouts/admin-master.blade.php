<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title') || Ranayas</title>



    <!-- General CSS Files -->
    <link rel="stylesheet" href="{!! asset('admin/css/app.min.css') !!}">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{!! asset('admin/css/custom.css') !!}">
    <link rel="shortcut icon" href="{!! asset('assets/image/logo/favicon-32x32.png') !!}">
    <link rel="stylesheet" href="{!! asset('admin/bundles/select2/dist/css/select2.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('admin/bundles/bootstrap-daterangepicker/daterangepicker.css') !!}">
    <link rel="stylesheet" href="{!! asset('admin/css/style.css') !!}">
    <link rel="stylesheet" href="{!! asset('admin/bundles/chocolat/dist/css/chocolat.css') !!}">
    <link rel="stylesheet" href="{!! asset('admin/css/components.css') !!}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <link rel="stylesheet" href="{!! asset('admin/bundles/summernote/summernote-bs4.css') !!}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css">
    @notifyCss
    <style>
        #laravel-notify,
        #laravel-notify .notify,
        #laravel-notify .notify.fixed,
        .notify-alert,
        .drake-alert,
        .smiley-alert,
        .connectify-alert {
            position: fixed !important;
            z-index: 99999 !important;
            top: 20px !important;
            right: 20px !important;
            left: auto !important;
        }

        #laravel-notify .notify {
            inset: 0 auto auto 0 !important;
            width: auto !important;
            min-width: 420px !important;
        }

        /* Smooth Logo Transition & Fix Resize Issue */
        .main-sidebar .sidebar-brand,
        .main-sidebar .sidebar-brand-sm {
            height: 70px;
            overflow: hidden;
            position: absolute;
            top: 0;
            left: 0;
            width: 250px;
            /* Matches expanded sidebar width */
            transition: opacity 0.5s ease-in-out, visibility 0.5s ease-in-out;
            z-index: 10;
            display: flex !important;
            align-items: center;
            justify-content: center;
        }

        .main-sidebar .sidebar-brand-sm {
            width: 65px;
            /* Matches collapsed sidebar width */
            opacity: 0;
            visibility: hidden;
        }

        .main-sidebar .sidebar-brand img {
            width: 200px;
            /* Fixed width prevents horizontal squeezing */
            height: auto;
        }

        .main-sidebar .sidebar-brand-sm img {
            width: 40px;
            /* Fixed width for mini logo */
            height: auto;
        }

        /* Ensure menu starts below absolute positioned logos */
        .main-sidebar .sidebar-menu {
            margin-top: 70px;
        }

        .sidebar-mini .main-sidebar .sidebar-brand:not(.sidebar-brand-sm) {
            opacity: 0;
            visibility: hidden;
        }

        .sidebar-mini .main-sidebar .sidebar-brand.sidebar-brand-sm {
            opacity: 1 !important;
            visibility: visible !important;
        }
    </style>
    @yield('extracss')
</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar sticky">
                <div class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn">
                                <i data-feather="align-justify"></i></a></li>
                        <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                                <i data-feather="maximize"></i>
                            </a></li>
                    </ul>
                </div>
                <ul class="navbar-nav navbar-right">
                    @if (auth('admin')->check())
                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown"
                                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                @if (auth('admin')->user()->image_url)
                                    <img alt="{{ auth('admin')->user()->name }}"
                                        src="/storage/images/admins/{{ auth('admin')->user()->image_url }}"
                                        class="user-img-radious-style">
                                    <span class="d-sm-none d-lg-inline-block"></span>
                                @else
                                    <img alt="Profile Photo" src="/admin/img/admin2.png" class="user-img-radious-style">
                                    <span class="d-sm-none d-lg-inline-block"></span>
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-right pullDown">
                                <div class="dropdown-title">Hello {{ auth('admin')->user()->name }}</div>
                                <a href="{{ route('admin.profile') }}" class="dropdown-item has-icon">
                                    <i class="far fa-user"></i> Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('admin.logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endif
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="{{ route('admin.dashboard') }}">
                            <img alt="image" src="{!! asset('assets/image/logo/ranayas-logo.png') !!}" />
                            {{-- <span class="logo-name">Ranayas</span> --}}
                        </a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="{{ route('admin.dashboard') }}">
                            <img alt="image" src="{!! asset('assets/image/logo/ranayas-logo-sidebar-small.jpg') !!}" />
                        </a>
                    </div>
                    <ul class="sidebar-menu">

                        {{-- <!-- Test here -->
                        <li class="dropdown">
                            <a href="{{ route('test.start.all') }}" class="nav-link"><i data-feather="headphones"></i><span>Test</span></a>
                        </li> --}}
                        <!-- End -->

                        <li class="menu-header">Manage Menu</li>
                        <li class="dropdown">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link"><i
                                    data-feather="monitor"></i><span>Dashboard</span></a>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="menu-toggle nav-link has-dropdown">
                                <i data-feather="layers"></i><span>Main catalogue</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="{{ route('admin.categories.all') }}">Categories</a></li>
                                <li><a class="nav-link" href="{{ route('admin.brands.all') }}">Brands</a></li>
                                <li><a class="nav-link" href="{{ route('admin.colors.all') }}">Colors</a></li>
                                <li><a class="nav-link" href="{{ route('admin.materials.all') }}">Materials</a></li>
                                <li><a class="nav-link" href="{{ route('admin.units.all') }}">Units</a></li>
                                <li><a class="nav-link" href="{{ route('admin.length_units.all') }}">Length Units</a>
                                </li>
                                <li><a class="nav-link" href="{{ route('admin.conditions.all') }}">Conditions</a>
                                </li>
                                <li><a class="nav-link" href="{{ route('admin.gsts.all') }}">GST</a></li>
                                <li><a class="nav-link" href="{{ route('admin.sizes.all') }}">Sizes</a></li>
                                <li><a class="nav-link" href="{{ route('admin.warranties.all') }}">Warranties</a>
                                </li>

                                <li><a class="nav-link" href="{{ route('admin.coupons.all') }}">Coupons</a></li>
                                <!-- <li><a class="nav-link" href="{{ route('admin.offers.all') }}">Offers</a></li> -->
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="menu-toggle nav-link has-dropdown">
                                <i data-feather="smartphone"></i><span>Orders</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="{{ route('admin.orders.all') }}">Search Order</a></li>
                                <li><a class="nav-link" href="{{ route('admin.invoices.all') }}">Manage Invoice</a>
                                </li>
                                <li><a class="nav-link" href="{{ route('admin.reports.all') }}">Manage Reports</a>
                                </li>

                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="{{ route('admin.products.all') }}" class="nav-link"><i
                                    data-feather="smartphone"></i><span>Products</span></a>
                        </li>

                        <li class="dropdown">
                            <a href="{{ route('admin.shop_by_budgets.index') }}" class="nav-link"><i
                                    data-feather="tag"></i><span>Shop by Budget</span></a>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="menu-toggle nav-link has-dropdown">
                                <i data-feather="file-text"></i><span>Policies</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link"
                                        href="{{ route('admin.policies.edit', 'terms-condition') }}">Terms &
                                        conditions</a></li>
                                <li><a class="nav-link" href="{{ route('admin.policies.edit', 'privacy') }}">Privacy
                                        policy</a></li>
                                <li><a class="nav-link"
                                        href="{{ route('admin.policies.edit', 'refund-return') }}">Return policy</a>
                                </li>
                                <li><a class="nav-link"
                                        href="{{ route('admin.policies.edit', 'shipping') }}">Shipping policy</a></li>
                                <li><a class="nav-link"
                                        href="{{ route('admin.policies.edit', 'cancellation') }}">Cancellation
                                        policy</a></li>
                            </ul>
                        </li>



                        <li class="dropdown">
                            <a href="{{ route('admin.users.all') }}" class="nav-link"><i
                                    data-feather="users"></i><span>Users</span></a>
                        </li>


                        <li class="dropdown">
                            <a href="{{ route('admin.files.all') }}" class="nav-link"><i
                                    data-feather="file"></i><span>Files/Image</span></a>
                        </li>

                        <li class="dropdown">
                            <a href="{{ route('admin.sliders.all') }}" class="nav-link"><i
                                    data-feather="link-2"></i><span>Slider</span></a>
                        </li>

                        <li class="dropdown">
                            <a href="{{ route('admin.home-offer-sliders.all') }}" class="nav-link"><i
                                    data-feather="monitor"></i><span>Home Offer Slider</span></a>
                        </li>

                        <li class="dropdown">
                            <a href="{{ route('admin.reviews.all') }}" class="nav-link"><i
                                    data-feather="star"></i><span>Reviews</span></a>
                        </li>

                        <li class="dropdown">
                            <a href="{{ route('admin.enquiries.all') }}" class="nav-link"><i
                                    data-feather="mail"></i><span>Enquiries</span></a>
                        </li>

                        <li class="dropdown">
                            <a href="{{ route('admin.bulks.all') }}" class="nav-link"><i
                                    data-feather="mail"></i><span>Bulk Order</span></a>
                        </li>

                        <li class="dropdown">
                            <a href="{{ route('admin.faqs.all') }}" class="nav-link"><i
                                    data-feather="message-square"></i><span>FAQ's</span></a>
                        </li>

                        {{-- <li class="dropdown">
                            <a href="{{ route('admin.subscribers.all') }}" class="nav-link"><i
                                    data-feather="users"></i><span>Subscribers</span></a>
                        </li> --}}


                        <li class="dropdown">
                            <a href="{{ route('admin.tickets.all') }}" class="nav-link">
                                <i data-feather="credit-card"></i>
                                <span>Raised Tickets</span>
                            </a>
                        </li>

                        <li class="dropdown">
                            <a href="{{ route('admin.return-tickets.all') }}" class="nav-link">
                                <i data-feather="credit-card"></i>
                                <span>Return & Refund Tickets</span>
                            </a>
                        </li>




                    </ul>



                </aside>
            </div>
            <!-- Main Content -->
            <div class="main-content">
                @yield('content')

                <div class="settingSidebar">
                    <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
                    </a>
                    <div class="settingSidebar-body ps-container ps-theme-default">
                        <div class=" fade show active">
                            <div class="setting-panel-header">Setting Panel
                            </div>
                            <div class="p-15 border-bottom">
                                <h6 class="font-medium m-b-10">Select Layout</h6>
                                <div class="selectgroup layout-color w-50">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="value" value="1"
                                            class="selectgroup-input-radio select-layout" checked>
                                        <span class="selectgroup-button">Light</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="value" value="2"
                                            class="selectgroup-input-radio select-layout">
                                        <span class="selectgroup-button">Dark</span>
                                    </label>
                                </div>
                            </div>
                            <div class="p-15 border-bottom">
                                <h6 class="font-medium m-b-10">Sidebar Color</h6>
                                <div class="selectgroup selectgroup-pills sidebar-color">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="icon-input" value="1"
                                            class="selectgroup-input select-sidebar">
                                        <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                                            data-src-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="icon-input" value="2"
                                            class="selectgroup-input select-sidebar" checked>
                                        <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                                            data-src-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
                                    </label>
                                </div>
                            </div>
                            <div class="p-15 border-bottom">
                                <h6 class="font-medium m-b-10">Color Theme</h6>
                                <div class="theme-setting-options">
                                    <ul class="choose-theme list-unstyled mb-0">
                                        <li title="white" class="active">
                                            <div class="white"></div>
                                        </li>
                                        <li title="cyan">
                                            <div class="cyan"></div>
                                        </li>
                                        <li title="black">
                                            <div class="black"></div>
                                        </li>
                                        <li title="purple">
                                            <div class="purple"></div>
                                        </li>
                                        <li title="orange">
                                            <div class="orange"></div>
                                        </li>
                                        <li title="green">
                                            <div class="green"></div>
                                        </li>
                                        <li title="red">
                                            <div class="red"></div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="p-15 border-bottom">
                                <div class="theme-setting-options">
                                    <label class="m-b-0">
                                        <input type="checkbox" name="custom-switch-checkbox"
                                            class="custom-switch-input" id="mini_sidebar_setting">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="control-label p-l-10">Mini Sidebar</span>
                                    </label>
                                </div>
                            </div>
                            <div class="p-15 border-bottom">
                                <div class="theme-setting-options">
                                    <label class="m-b-0">
                                        <input type="checkbox" name="custom-switch-checkbox"
                                            class="custom-switch-input" id="sticky_header_setting">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="control-label p-l-10">Sticky Header</span>
                                    </label>
                                </div>
                            </div>
                            <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
                                <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
                                    <i class="fas fa-undo"></i> Restore Default
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="main-footer bg-dark">
                <div class="footer-left">
                    Copyright &copy; {{ date('Y') }}
                    <div class="bullet"></div> Ranayas
                    {{-- - Designed & Developed By <a href="https://www.sanjaresolutions.com" target="_blank">Sanjar E
                        Solutions</a> --}}
                </div>
            </footer>
        </div>
    </div>
    <!-- General JS Scripts -->
    <script src="{!! asset('admin/js/app.min.js') !!}"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.plugins.min.js">
    </script>
    <!-- JS Libraies -->
    <!-- Template JS File -->
    <!-- Custom JS File -->
    <script src="{!! asset('admin/js/custom.js') !!}"></script>
    <script src="{!! asset('admin/js/jquery.validate.min.js') !!}"></script>
    <script src="{!! asset('admin/bundles/select2/dist/js/select2.full.min.js') !!}"></script>
    <script src="{!! asset('admin/js/scripts.js') !!}"></script>
    <script src="{!! asset('admin/bundles/bootstrap-daterangepicker/daterangepicker.js') !!}"></script>
    <script src="{!! asset('assets/js/jquery.lazyload.js') !!}"></script>
    <script src="{!! asset('admin/bundles/summernote/summernote-bs4.js') !!}"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {

            $(".lazy").Lazy({
                effect: 'fadeIn',
                visibleOnly: true,
            });

            $('.datatable').dataTable({
                "order": []
            });
        });
    </script>
    @yield('extrajs')
    @include('notify::components.notify')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @notifyJs
</body>

</html>
