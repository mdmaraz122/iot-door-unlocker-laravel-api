<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title') - Smart Unlock</title>

    {{-- ================= CSS ================= --}}

    {{-- Main App CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/jquery-selectric/selectric.css') }}">

    {{-- DataTables --}}
    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">

    {{-- Toastify & Loader --}}
    <link rel="stylesheet" href="{{ asset('css/toastify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/progress.css') }}">

    {{-- Select2 --}}
    <link rel="stylesheet" href="{{ asset('assets/bundles/select2/dist/css/select2.min.css') }}">

    {{-- Font Awesome --}}
    <link rel="stylesheet"
          href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css') }}">

    {{-- Favicon --}}
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/smart-unlock.png') }}"/>

    {{-- ================= JS (HEAD – only jQuery) ================= --}}

    {{-- jQuery (MUST be first) --}}
    <script src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
</head>

<body>

<audio src="{{ asset('audio/notifi.mp3') }}" class="d-none" id="notifi"></audio>
<div id="loader" class="LoadingOverlay">
    <div class="Line-Progress">
        <div class="indeterminate"></div>
    </div>
</div>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar sticky">
            <div class="form-inline mr-auto">
                <ul class="navbar-nav mr-3">
                    <li>
                        <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn">
                            <i data-feather="align-justify"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link nav-link-lg fullscreen-btn">
                            <i data-feather="maximize"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <ul class="navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <img alt="image" src="{{ asset('assets/img/user.png') }}" class="user-img-radious-style">
                        <span class="d-sm-none d-lg-inline-block"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right pullDown">
                        <a href="{{ route('backend.profile') }}" class="dropdown-item has-icon">
                            <i class="far fa-user"></i>
                            Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('backend.logout') }}" class="dropdown-item has-icon text-danger">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <div class="main-sidebar sidebar-style-2">
            <aside id="sidebar-wrapper">
                <div class="sidebar-brand">
                    <a href="{{ route('backend.dashboard') }}">
                        <img alt="image" src="{{ asset('images/smart-unlock.png') }}" class="header-logo"/>
                        <span class="logo-name">Smart Unlock</span>
                    </a>
                </div>
                <ul class="sidebar-menu">
                    {{--Dashboard--}}
                    @can('dashboard')
                    <li class="dropdown {{ request()->routeIs('backend.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('backend.dashboard') }}" class="nav-link">
                            <i class="fa-solid fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    @endcan
                    {{--passkey-lock--}}
                    @can('passkey-lock')
                        <li class="dropdown {{ request()->routeIs('backend.passkey') ? 'active' : '' }}">
                            <a href="{{ route('backend.passkey') }}" class="nav-link">
                                <i class="fa-solid fa-key"></i>
                                <span>Pass Key</span>
                            </a>
                        </li>
                    @endcan
                    {{--Users--}}
                    @can('user-list')
                    <li class="dropdown {{ request()->routeIs('backend.users', 'backend.roles', 'backend.permissions') ? 'active' : '' }}">
                        <a href="#" class="menu-toggle nav-link has-dropdown">
                            <i class="fa-solid fa-users"></i>
                            <span>Users</span>
                        </a>
                        <ul class="dropdown-menu">
                            @can('user-list')
                                <li class="{{ request()->routeIs('backend.users') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('backend.users') }}">Users</a>
                                </li>
                            @endcan
                            @can('role-list')
                                <li class="{{ request()->routeIs('backend.roles') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('backend.roles') }}">Roles</a>
                                </li>
                            @endcan
                            @can('permission-list')
                                <li class="{{ request()->routeIs('backend.permissions') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('backend.permissions') }}">Permissions</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    @endcan
                    {{--Logs--}}
                    @can('user-logs')
                        <li class="dropdown {{ request()->routeIs('backend.logs') ? 'active' : '' }}">
                            <a href="{{ route('backend.logs') }}" class="nav-link">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                                <span>Unlock Logs</span>
                            </a>
                        </li>
                    @endcan
                    {{--Settings--}}
                    @can('settings')
                        <li class="dropdown {{ request()->routeIs('backend.settings') ? 'active' : '' }}">
                            <a href="{{ route('backend.settings') }}" class="nav-link">
                                <i class="fa-solid fa-gear"></i>
                                <span>Settings</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </aside>
        </div>
        {{--Main Content--}}
        <div class="main-content">
            @yield('content')
        </div>
        {{--Footer--}}
        <footer class="main-footer bg-dark">
            <div class="footer-left">
                <div class="text-white">
                    Developed By
                    <a href="{{ url('https://www.rawitsolutions.com') }}" class="text-white" target="_blank">Md. Maraz</a>
                </div>
            </div>
            <div class="footer-right">
            </div>
        </footer>
    </div>
</div>







{{-- App JS --}}
<script src="{{ asset('assets/js/app.min.js') }}"></script>

{{-- Select2 --}}
<script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>

{{-- DataTables --}}
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>

{{-- Toastify --}}
<script src="{{ asset('js/toastify-js.js') }}"></script>

{{-- Axios --}}
<script src="{{ asset('js/axios.min.js') }}"></script>

{{-- Config --}}
<script src="{{ asset('js/config.js') }}"></script>

{{-- Select2 Init --}}
<script>
    $(document).ready(function () {
        // Initialize Select2 when modal is shown
        $('#create-modal').on('shown.bs.modal', function () {
            $('.select2').select2({
                placeholder: 'Select option',
                allowClear: true,
                dropdownParent: $('#create-modal') // Use modal ID for proper dropdown positioning
            });
        });

        // Destroy Select2 when modal is hidden to prevent issues
        $('#create-modal').on('hidden.bs.modal', function () {
            $('.select2').select2('destroy');
        });

        // For update modal if you have one
        $('#update-modal').on('shown.bs.modal', function () {
            $('.select2').select2({
                placeholder: 'Select option',
                allowClear: true,
                dropdownParent: $('#update-modal')
            });
        });

        $('#update-modal').on('hidden.bs.modal', function () {
            $('.select2').select2('destroy');
        });
    });
</script>








{{--General JS Scripts--}}

{{--JS Libraies--}}
<script src="{{ asset('assets/bundles/apexcharts/apexcharts.min.js') }}"></script>
{{--Page Specific JS File--}}
<script src="{{ asset('assets/js/page/index.js') }}"></script>
{{--Template JS File--}}
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('assets/bundles/jquery-selectric/jquery.selectric.min.js') }}"></script>
{{--Custom JS File--}}
<script src="{{ asset('assets/js/custom.js') }}"></script>
@yield('scripts')
</body>
</html>
