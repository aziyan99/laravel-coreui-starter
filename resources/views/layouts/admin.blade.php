<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keyword" content="">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- Vendors styles-->
    <link rel="stylesheet" href="{{ asset('vendors/simplebar/css/simplebar.css') }}">
    <x-favicon />
    <link rel="stylesheet" href="{{ asset('css/vendors/simplebar.css') }}">
    <!-- Main styles for this application-->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<body>
<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <x-admin.side-logo />
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        @can('dashboard_view')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard.index') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-speedometer') }}"></use>
                    </svg> {{ __('Dashboard') }}
                    <span class="badge badge-sm bg-info ms-auto">NEW</span>
                </a>
            </li>
        @endcan
        @can('role_view')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('roles.index') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-lock-locked') }}"></use>
                    </svg>
                    {{ __('Role') }}
                </a>
            </li>
        @endcan
        @can('permission_view')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('permissions.index') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-shield-alt') }}"></use>
                    </svg>
                    {{ __('Permission') }}
                </a>
            </li>
        @endcan
        @can('user_view')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.index') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-people') }}"></use>
                    </svg>
                    {{ __('Users') }}
                </a>
            </li>
        @endcan
        @can('setting_view')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('settings.index') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-cog') }}"></use>
                    </svg>
                    {{ __('Settings') }}
                </a>
            </li>
        @endcan
            <li class="nav-item">
                <a class="nav-link" href="{{ route('profile.index') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-lock-locked') }}"></use>
                    </svg>
                    {{ __('Profile') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-account-logout') }}"></use>
                    </svg>
                    {{ __('Logout') }}
                </a>
            </li>
    </ul>
    <div class="sidebar-toggler"></div>
</div>
<div class="wrapper d-flex flex-column min-vh-100 bg-light">
    <header class="header header-sticky mb-4">
        <div class="container-fluid">
            <button class="header-toggler px-md-0 me-md-3" type="button"
                    onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
                <svg class="icon icon-lg">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-menu') }}"></use>
                </svg>
            </button>
            <ul class="header-nav d-none d-md-flex">
                @can('dashboard_view')
                    <li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>
                @endcan
                @can('user_view')
                    <li class="nav-item"><a class="nav-link" href="#">Users</a></li>
                @endcan
                @can('setting_view')
                    <li class="nav-item"><a class="nav-link" href="#">Settings</a></li>
                @endcan
            </ul>
            <ul class="header-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <svg class="icon icon-lg">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-bell') }}"></use>
                        </svg>
                    </a>
                </li>
            </ul>
            <ul class="header-nav ms-3">
                <li class="nav-item dropdown">
                    <a class="nav-link py-0" data-coreui-toggle="dropdown" href="javascript:void(0);"
                       role="button" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar avatar-md"><img class="avatar-img"
                                                           src="{{ (auth()->user()->avatar != null) ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?size=256&background=0D8ABC&color=fff&name=' . auth()->user()->name }}"
                                                           alt="img"></div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end pt-0">
                        <a class="dropdown-item" href="{{ route('profile.index') }}">
                            <svg class="icon me-2">
                                <use
                                    xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-lock-locked') }}">
                                </use>
                            </svg>
                            {{ __('Profile') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();">
                            <svg class="icon me-2">
                                <use
                                    xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-account-logout') }}">
                                </use>
                            </svg>
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
        <div class="header-divider"></div>
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb my-0 ms-2">
                    @yield('breadcump')
                </ol>
            </nav>
        </div>
    </header>
    <div class="body flex-grow-1 px-3">
        @yield('main')
    </div>
    <footer class="footer">
        <div>© 2022.</div>
    </footer>
</div>
<!-- CoreUI and necessary plugins-->
<script src="{{ asset('vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
<script src="{{ asset('vendors/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ asset('vendors/@coreui/utils/js/coreui-utils.js') }}"></script>
@include('sweetalert::alert')
@stack('scripts')
</body>

</html>
