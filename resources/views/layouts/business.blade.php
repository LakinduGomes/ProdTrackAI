<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('layout_style/img/asset_logo.png') }}">
    <title>
        @yield('title') | {{ env('APP_NAME') }}
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link rel="stylesheet" type="text/css" href="{{ asset('layout_style/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('layout_style/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('layout_style/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('layout_style/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('layout_style/css/feather.css') }}">
    {{--
    <link rel="stylesheet" type="text/css" href="{{ asset('layout_style/css/style.css') }}"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="{{ asset('layout_style/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('layout_style/css/style.css?v=') . time() }}">
    <link rel="stylesheet" href="{{ asset('layout_style/jquery_confirm/style.css') }}">
    <link rel="stylesheet" href="{{ asset('layout_style/css/my-style.css?v=') . time() }}">
    <link rel="stylesheet" href="{{ asset('layout_style/css/bootstrap-datetimepicker.min.css') }}">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('layout_style/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('layout_style/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="{{ asset('layout_style/js/validations.js') }}"></script>
    <script src="{{ asset('layout_style/js/fileupload.js') }}"></script>

    <script type="text/javascript">
        window.history.forward();

        function noBack() {
            window.history.forward();
            window.menubar.visible = false;
        }
    </script>


    @yield('style')


    

    <style>
        /* ===== Base theme (matches dashboard — dark by default, not a toggle) ===== */
        :root {
            --canvas:  #0A0D14;
            --panel:   #12161F;
            --panel-2: #171C27;
            --ink:     #E7E9EE;
            --ink-soft:#C3C8D4;
            --muted:   #8891A5;
            --muted-2: #6b7280;
            --hairline: rgba(255,255,255,.07);
            --hairline-strong: rgba(255,255,255,.14);
            --brass:   #818CF8;
            --brass-strong: #6366F1;
            --red:     #F87171;
        }

        html, body {
            background-color: var(--canvas) !important;
            color: var(--ink) !important;
        }

        .main-wrapper .header {
            background-color: var(--panel) !important;
            border-bottom: 1px solid var(--hairline) !important;
        }

        .header .logo span {
            color: var(--ink) !important;
        }

        .compact-toggle {
            color: var(--ink) !important;
        }

        .compact-toggle svg {
            stroke: var(--ink) !important;
        }

        .user-menu .user-link .user-names h5 {
            color: var(--ink) !important;
        }

        .sidebar {
            background-color: var(--panel) !important;
            border-right: 1px solid var(--hairline) !important;
        }

        .sidebar-inner,
        #sidebar-menu {
            background-color: var(--panel) !important;
        }

        .sidebar-menu ul li.menu-title {
            color: var(--muted-2) !important;
        }

        .sidebar-menu ul li > a {
            color: var(--ink-soft) !important;
        }

        .sidebar-menu ul li > a:hover,
        .sidebar-menu ul li.active > a {
            background-color: var(--panel-2) !important;
            color: var(--brass) !important;
        }

        .sidebar-menu .sub-menu {
            background-color: #0f1319 !important;
        }

        .sidebar-menu .sub-menu li a {
            color: var(--muted) !important;
        }

        .sidebar-menu .sub-menu li a:hover {
            color: var(--brass) !important;
        }

        .logout-btn a {
            color: var(--red) !important;
        }

        .page-wrapper,
        .page-wrapper .content {
            background-color: var(--canvas) !important;
        }

        .dropdown-menu {
            background-color: var(--panel) !important;
            color: var(--ink) !important;
            border: 1px solid var(--hairline-strong) !important;
        }

        .dropdown-item {
            color: var(--ink-soft) !important;
        }

        .dropdown-item:hover {
            background-color: var(--panel-2) !important;
            color: var(--ink) !important;
        }

        .modal-content {
            background-color: var(--panel) !important;
            color: var(--ink) !important;
            border: 1px solid var(--hairline-strong) !important;
        }

        .modal-header {
            background-color: var(--panel-2) !important;
            border-bottom: 1px solid var(--hairline) !important;
        }

        .modal-header .modal-title,
        .modal-title i {
            color: var(--ink) !important;
        }

        .btn-close {
            filter: invert(1) brightness(2);
        }

        .form-control,
        .form-select,
        select,
        textarea {
            background-color: var(--panel-2) !important;
            color: var(--ink) !important;
            border-color: var(--hairline-strong) !important;
        }

        .form-floating label {
            color: var(--muted) !important;
        }

        .btn-primary {
            background-color: var(--brass-strong) !important;
            border-color: var(--brass-strong) !important;
        }

        .btn-primary:hover {
            background-color: #4f52e0 !important;
        }

        .btn-outline-secondary {
            color: var(--ink-soft) !important;
            border-color: var(--hairline-strong) !important;
        }
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            z-index: 5;
        }
        
    </style>
    <style>
        .compact-toggle {
            background: transparent;
            border: none;
            padding: 4px;
            width: 32px;
            height: 32px;
            cursor: pointer;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .compact-toggle .icon {
            position: absolute;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .compact-toggle .moon {
            opacity: 0;
            transform: scale(0.5);
        }

        body.dark-mode .compact-toggle .sun {
            opacity: 0;
            transform: scale(0.5);
        }

        body.dark-mode .compact-toggle .moon {
            opacity: 1;
            transform: scale(1);
        }

        /* ===== Dark mode base ===== */
        body.dark-mode {
            background-color: #0A0D14;
            color: #ffffff !important;
        }

        .dark-mode * {
            color: #ffffff !important;
            border-color: #444 !important;
        }

        .dark-mode .card,
        .dark-mode .header,
        .dark-mode .sidebar-menu,
        .dark-mode .topbar,
        .dark-mode .modal-content {
            background-color: #1e1e1e !important;
        }

        /* ===== Header / logo bar ===== */
        .dark-mode .main-wrapper .header {
            background-color: #12161F !important;
            border-bottom: 1px solid rgba(255, 255, 255, .07) !important;
        }

        .dark-mode .header .logo span {
            color: #E7E9EE !important;
        }

        .dark-mode .compact-toggle {
            color: #E7E9EE !important;
        }

        .dark-mode .compact-toggle svg {
            stroke: #E7E9EE !important;
        }

        .dark-mode .user-menu .user-link .user-names h5 {
            color: #E7E9EE !important;
        }

        /* ===== Sidebar / navigation ===== */
        .dark-mode .sidebar {
            background-color: #12161F !important;
            border-right: 1px solid rgba(255, 255, 255, .07) !important;
        }

        .dark-mode .sidebar-inner,
        .dark-mode #sidebar-menu {
            background-color: #12161F !important;
        }

        .dark-mode .sidebar-menu ul li.menu-title {
            color: #6b7280 !important;
        }

        .dark-mode .sidebar-menu ul li > a {
            color: #C3C8D4 !important;
        }

        .dark-mode .sidebar-menu ul li > a:hover,
        .dark-mode .sidebar-menu ul li.active > a {
            background-color: #171C27 !important;
            color: #818CF8 !important;
        }

        .dark-mode .sidebar-menu .sub-menu {
            background-color: #0f1319 !important;
        }

        .dark-mode .sidebar-menu .sub-menu li a {
            color: #9AA1B0 !important;
        }

        .dark-mode .sidebar-menu .sub-menu li a:hover {
            color: #818CF8 !important;
        }

        .dark-mode .sidebar-menu .menu-arrow {
            border-color: #6b7280 transparent transparent !important;
        }

        .dark-mode .logout-btn a {
            color: #F87171 !important;
        }

        /* ===== Page body ===== */
        .dark-mode .page-wrapper,
        .dark-mode .page-wrapper .content {
            background-color: #0A0D14 !important;
        }

        .dark-mode table,
        .dark-mode thead,
        .dark-mode th,
        .dark-mode td,
        .dark-mode .dataTables_wrapper {
            background-color: #1e1e1e !important;
            color: #ffffff !important;
        }

        .dark-mode .dataTables_wrapper,
        .dark-mode .dataTables_wrapper * {
            color: #ffffff !important;
        }

        /* DataTables elements */
        .dark-mode table.dataTable,
        .dark-mode table.dataTable th,
        .dark-mode table.dataTable td {
            color: #ffffff !important;
            background-color: #1e1e1e !important;
            border-color: #444 !important;
        }

        /* Pagination buttons */
        .dark-mode .dataTables_paginate .paginate_button {
            color: #ffffff !important;
            background-color: #333 !important;
            border: 1px solid #555 !important;
        }

        .dark-mode .dataTables_paginate .paginate_button.current,
        .dark-mode .dataTables_paginate .paginate_button:hover {
            background-color: #555 !important;
            color: #fff !important;
            border-color: #888 !important;
        }

        /* Search input and length selector */
        .dark-mode .dataTables_filter input,
        .dark-mode .dataTables_length select {
            background-color: #2b2b2b !important;
            color: #ffffff !important;
            border: 1px solid #555 !important;
        }

        /* Info text below table */
        .dark-mode .dataTables_info {
            color: #ffffff !important;
        }

        /* DataTables buttons */
        .dark-mode .dt-button,
        .dark-mode .buttons-html5 {
            background-color: #444 !important;
            color: #fff !important;
            border: 1px solid #666 !important;
        }

        /*white color to labels inside tables */
        .dark-mode .table .form-label,
        .dark-mode .table td label {
            color: #ffffff !important;
        }

        /* white text and dark background to table cells in borderless tables */
        .dark-mode .table-borderless td {
            background-color: transparent !important;
            color: #ffffff !important;
            border: none !important;
        }

        /*input fields in tables are dark and text is white */
        .dark-mode .table input.form-control {
            background-color: #2b2b2b !important;
            color: #ffffff !important;
            border: 1px solid #555 !important;
        }

        .dark-mode .form-control,
        .dark-mode input,
        .dark-mode select,
        .dark-mode textarea {
            background-color: #2b2b2b !important;
            color: #ffffff !important;
            border-color: #555 !important;
        }

        .dark-mode .form-floating label {
            color: #8891A5 !important;
        }

        .dark-mode .btn {
            background-color: #333 !important;
            color: #ffffff !important;
            border-color: #555 !important;
        }

        .dark-mode .btn:hover {
            background-color: #444 !important;
            border-color: #666 !important;
        }

        .dark-mode .btn-primary {
            background-color: #6366F1 !important;
            border-color: #6366F1 !important;
        }

        .dark-mode .btn-primary:hover {
            background-color: #4f52e0 !important;
        }

        .dark-mode .pagination>li>a {
            background-color: #2c2c2c !important;
            color: #fff !important;
        }

        .dark-mode .dropdown-menu {
            background-color: #2b2b2b !important;
            color: #fff !important;
        }

        .dark-mode .dropdown-item:hover {
            background-color: #444 !important;
            color: #fff !important;
        }

        /* Submenu text color */
        .dark-mode .treeview-menu li a,
        .dark-mode .nav-submenu li a,
        .dark-mode .submenu li a {
            color: #ffffff !important;
        }

        .dark-mode .autocomplete-suggestions,
        .dark-mode .autocomplete-suggestion {
            background-color: #1e1e1e !important;
            color: #ffffff !important;
            border-color: #444 !important;
        }

        .dark-mode #autocomplete-list li {
            color: #ffffff !important;
            background-color: #1e1e1e !important;
            border-bottom: 1px solid #444 !important;
        }

        .dark-mode .table th:nth-of-type(1),
        .dark-mode .table td:nth-of-type(1) {
            background-color: #1e1e1e !important;
            color: #ffffff !important;
            border-color: #333 !important;
        }

        .dark-mode .table tbody tr:hover td:nth-of-type(1) {
            background-color: #2a2a2a !important;
            color: #fff !important;
        }

        .dark-mode .modal-header {
            background-color: #000000 !important;
            color: #ffffff !important;
            border-bottom: 1px solid #444 !important;
        }

        .dark-mode .modal-header .modal-title {
            color: #ffffff !important;
        }

        .dark-mode .btn-close {
            filter: invert(1) brightness(2);
        }

        .dark-mode .level-item {
            color: #000 !important;
        }

        .dark-mode .level-item .badge.bg-custom-blue {
            background-color: #375a7f !important;
            color: #ffffff !important;
        }

        body.dark-mode .swal2-popup {
            background-color: #1e1e1e !important;
            color: #eee !important;
            border: none !important;
            box-shadow: 0 0 15px #000 !important;
        }

        body.dark-mode .swal2-popup .swal2-title,
        body.dark-mode .swal2-popup .swal2-content {
            color: #eee !important;
        }

        body.dark-mode .swal2-popup .swal2-styled {
            background-color: #375a7f !important;
            color: #fff !important;
            border: none !important;
        }

        body.dark-mode .swal2-popup .swal2-styled:hover {
            background-color: #286090 !important;
        }

        body.dark-mode .swal2-popup .swal2-icon.swal2-warning {
            border-color: #d67f00 !important;
            color: #d67f00 !important;
        }

        /* applying dark mode theme for mobile view */
        @media (max-width: 768px) {

            #darkModeToggle {
                display: inline-flex !important;
                align-items: center;
                justify-content: center;
                padding: 6px 10px;
                margin-left: 10px;
                cursor: pointer;
                background: transparent;
                border: none;
                color: #333;
                font-size: 18px;
                width: 40px;
                height: 40px;
                border-radius: 8px;
                transition: background-color 0.3s ease;
                margin-bottom: 30px;
            }

            .nav.user-menu {
                display: flex !important;
                align-items: center;
                margin-top: 20px;
            }
        }
    </style>

</head>

<body onLoad="noBack();" onpageshow="if (event.persisted) noBack();" onUnload="" class="mini-sidebar">
    <div class="main-wrapper">
        <div class="header admin-dashboard">
            <div class="header-left">
                <a href="javascript:;" class="logo">
                    <img src="{{ asset('layout_style/img/prod.png') }}" width="45" height="45" alt>
                    <span style="font-size: 10px;">{{ env('APP_NAME') }}</span>
                </a>
            </div>

            <a id="toggle_btn" href="javascript:;"><img src="{{ asset('layout_style/img/icons/menu-bar.svg') }}"
                    style="width: 40px;" alt></a>
            <a id="mobile_btn" class="mobile_btn float-start" href="#sidebar"><img
                    src="{{ asset('layout_style/img/icons/menu-bar.svg') }}" style="width:24px" alt></a>

            <ul class="nav user-menu float-end">
                <li class="nav-item dropdown has-arrow user-profile-list">
                    <a href="#" class="dropdown-toggle nav-link user-link" data-bs-toggle="dropdown">
                        <div class="user-names">
                            <h5>{{ ucfirst(Auth::user()->first_name) . ' ' . ucfirst(Auth::user()->last_name) }} </h5>
                            {{-- <span>Admin</span> --}}
                        </div>
                        <span class="user-img">
                            {{-- <img src="{{ config('aws_url.url') . Auth::user()->UserProfile->profile }}"
                                style="border-radius:50%; width: 40px; height: 40px; object-fit: cover;" alt=""> --}}
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" onclick="openChangePasswordModal()">Change Password</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    </div>
                </li>

            </ul>
            <!-- <div class="dropdown mobile-user-menu float-end">

            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i
                    class="fa-solid fa-ellipsis-vertical"></i></a>
            <div class="dropdown-menu dropdown-menu-end">
            <a class="dropdown-item" href="#" onclick="openChangePasswordModal()">Change Password</a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            </div>
        </div> -->

           <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content shadow-lg border-0 rounded-4">
                    <div class="modal-header rounded-top-4 bg-light">
                        <h5 class="modal-title" id="changePasswordLabel">
                            <i class="bi bi-lock-fill me-2"></i>Change Password
                        </h5>
                        <button type="button" class="btn-close" onclick="closeChangePasswordModal()"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="form-floating mb-3 position-relative">
                            <input type="password" class="form-control" id="currentPassword"
                                placeholder="Current Password">
                            <label for="currentPassword">Current Password</label>
                            <i class="bi bi-eye-slash toggle-password"
                                onclick="togglePassword('currentPassword', this)"></i>
                        </div>

                        <div class="form-floating mb-3 position-relative">
                            <input type="password" class="form-control" id="newPassword" placeholder="New Password">
                            <label for="newPassword">New Password</label>
                            <i class="bi bi-eye-slash toggle-password"
                                onclick="togglePassword('newPassword', this)"></i>
                        </div>

                        <div class="form-floating position-relative">
                            <input type="password" class="form-control" id="confirmPassword"
                                placeholder="Confirm New Password">
                            <label for="confirmPassword">Confirm New Password</label>
                            <i class="bi bi-eye-slash toggle-password"
                                onclick="togglePassword('confirmPassword', this)"></i>
                        </div>
                    </div>
                    <div class="modal-footer px-4 pb-4 border-0">
                        <button type="button" class="btn btn-primary w-100"
                            style="padding-top: 0.75rem; padding-bottom: 0.75rem;"
                            onclick="submitChangePassword()">Update Password</button>
                        <button type="button" class="btn btn-outline-secondary w-100 mt-2"
                            onclick="closeChangePasswordModal()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            function openChangePasswordModal() {
                const modal = new bootstrap.Modal(document.getElementById('changePasswordModal'), {
                    backdrop: 'static',
                    keyboard: false
                });
                modal.show();
            }

            function togglePassword(fieldId, icon) {
                const input = document.getElementById(fieldId);
                const isPassword = input.type === "password";
                input.type = isPassword ? "text" : "password";
                icon.classList.toggle("bi-eye");
                icon.classList.toggle("bi-eye-slash");
            }

            function closeChangePasswordModal() {
                const modalEl = document.getElementById('changePasswordModal');
                const modalInstance = bootstrap.Modal.getInstance(modalEl);
                modalInstance.hide();
            }

            function submitChangePassword() {
                const current = document.getElementById('currentPassword').value.trim();
                const newPass = document.getElementById('newPassword').value.trim();
                const confirmPass = document.getElementById('confirmPassword').value.trim();

                if (!current || !newPass || !confirmPass) {
                    Swal.fire('Error', 'All fields are required.', 'error');
                    return;
                }

                if (newPass.length < 8) {
                    Swal.fire('Error', 'New password must be at least 8 characters.', 'error');
                    return;
                }

                if (newPass !== confirmPass) {
                    Swal.fire('Error', 'New password and confirmation do not match.', 'error');
                    return;
                }

                if (current === newPass) {
                    Swal.fire('Error', 'New password must be different from the current password.', 'error');
                    return;
                }

                fetch('{{ route("password.change") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        current_password: current,
                        new_password: newPass,
                        new_password_confirmation: confirmPass
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Success', data.message, 'success').then(() => {
                                window.location.href = data.redirect || '/login';
                            });
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(() => {
                        Swal.fire('Error', 'Something went wrong.', 'error');
                    });
            }

        </script>


@php
    $segment = Request::segment(1);
    $segment2 = Request::segment(2);
    $userLevel  = Auth::user()->level;
    $isReadOnly = in_array($userLevel, [3, 4, 5, 6]);
@endphp

<style>
    .sidebar {
        height: 100vh;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .sidebar-inner {
        flex-grow: 1;
        overflow-y: auto;
        max-height: calc(100vh - 15px);
    }

    .sidebar-menu {
        overflow-y: auto;
        max-height: 100%;
    }

    .sub-menu {
        max-height: 250px;
        overflow-y: auto;
    }
</style>

<div class="sidebar" id="sidebar" style="margin-top: -15px;">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu" style="height: 2000px;">
            <ul>
                <li class="menu-title">{{ session()->get('_business_name') }}</li>

                <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <span class="menu-side">
                            <img src="{{ asset('layout_style/img/icons/dashboard_admin.png') }}" style="width: 24px" alt>
                        </span>
                        <span>Dashboard</span>
                    </a>
                </li>

                <?php
                // Level 2 = Employee always gets modules 2 and 9
                // All others use $user_modules from DB
                $isEmployee = Auth::user()->level == 2;

                $moduleMap = [
                    'Task Management' => [
                        'modules' => [1],
                        'icon' => 'tasks.png',
                        'levels' => [999, 1, 3, 4, 5, 6],
                        'items' => [
                            1 => ['label' => 'Task Board (Manage All Tasks)', 'route' => 'business.tasks.index'],
                        ],
                    ],
                    'Work Execution' => [
                        'modules' => [2],
                        'icon' => 'workflow.png',
                        'levels' => [999, 1, 2, 3, 4, 5, 6],
                        'items' => [
                            2 => ['label' => 'My Tasks', 'route' => 'business.tasks.my'],
                        ],
                    ],
                    'Team Management' => [
                        'modules' => [3, 4],
                        'icon' => 'team.png',
                        'levels' => [999, 1, 3, 4, 5, 6],
                        'items' => [
                            3 => ['label' => 'Employees', 'route' => 'business.employees.index'],
                            4 => ['label' => 'Workload Distribution', 'route' => 'business.performance.workload'],
                        ],
                    ],
                    'Performance Insights' => [
                        'modules' => [5, 6],
                        'icon' => 'analytics.png',
                        'levels' => [999, 1, 3, 4, 5, 6],
                        'items' => [
                            5 => ['label' => 'Productivity Reports', 'route' => 'business.performance.reports'],
                            6 => ['label' => 'Analytics Overview', 'route' => 'business.performance.analytics'],
                        ],
                    ],
                    'AI Intelligence' => [
                        'modules' => [7, 8],
                        'icon' => 'ai.png',
                        'levels' => [999, 1, 3, 4, 5, 6],
                        'items' => [
                            7 => ['label' => 'Risk Predictions', 'route' => 'business.ai.predictions'],
                            8 => ['label' => 'Delay Probability Model', 'route' => 'business.ai.model'],
                            17 => ['label' => 'ML Evaluation Reports',   'route' => 'ml.reports'],
                        ],
                    ],
                    'Excel Import' => [
                        'modules' => [18],
                        'icon' => 'analytics.png',
                        'levels' => [999, 1, 3, 4, 5, 6],
                        'items' => [
                            18 => ['label' => 'Excel Import & Analysis', 'route' => 'import.index'],
                        ],
                    ],
                    'Notifications' => [
                        'modules' => [9],
                        'icon' => 'notification.png',
                        'levels' => [999, 1, 2, 3, 4, 5, 6],
                        'items' => [
                            9 => ['label' => 'Alerts Center', 'route' => 'business.notifications.index'],
                        ],
                    ],
                  'Admin & Settings' => [
                        'modules' => [15, 16],
                        'icon' => 'settings.png',
                        'levels' => [999],
                        'items' => [
                            15 => ['label' => 'System Users',  'route' => 'admin.userroles.index'],
                            16 => ['label' => 'Audit Log',     'route' => 'audit.index'],
                        ],
                    ],
                ];

                // For employees, force modules 2 and 9 regardless of user_modules table
                if ($isEmployee) {
                    $availableModules = [2, 9];
                } else {
                    $availableModules = collect($user_modules)->pluck('module')->toArray();
                }
                ?>

                <?php foreach ($moduleMap as $section => $data): ?>
                    <?php
                    $canSee = in_array($userLevel, $data['levels']);
                    $showSection = $canSee && count(array_intersect($availableModules, $data['modules'])) > 0;
                    ?>
                    <?php if ($showSection): ?>
                        <li class="submenu">
                            <a href="javascript:;" style="display: flex; align-items: center;">
                                <span class="menu-side">
                                    <img src="{{ asset('layout_style/img/icons/' . $data['icon']) }}" style="width: 20px;" alt>
                                </span>
                                <span style="flex: 1; font-size: 14px;"><?= $section ?></span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="sub-menu" style="margin-left: -10px;">
                                <?php foreach ($data['items'] as $mod => $info): ?>
                                    <?php if (is_array($info) && in_array($mod, $availableModules)): ?>
                                        <li>
                                            <a href="{{ route($info['route']) }}">
                                                {{ $info['label'] }}
                                                <?php if ($isReadOnly): ?>
                                                    <i class="fas fa-lock" style="font-size:10px;color:#f59e0b;margin-left:4px;"></i>
                                                <?php endif; ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>

            <div class="logout-btn">
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="menu-side"><img src="{{ asset('layout_style/img/icons/logout.ico') }}" alt></span>
                    <span>Logout</span></a>
            </div>
        </div>
    </div>
</div>

        <div class="page-wrapper">
            <div class="content">

                @yield('content')

            </div>
        </div>

        <!--loader-->
        <div class="ajax-loader" id="loader" style="display: none">
            <div class="max-loader">
                <div class="loader-inner">
                    <div class="spinner-border text-white" role="status"></div>
                    <p>Please Wait........</p>
                </div>
            </div>
        </div>
        <!--end loader-->
    </div>
    <div class="sidebar-overlay" data-reff></div>



    <script src="{{ asset('layout_style/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('layout_style/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('layout_style/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('layout_style/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('layout_style/js/app.js') }}"></script>
    <script src="{{ asset('layout_style/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('layout_style/plugins/select2/js/custom-select.js') }}"></script>
    <script src="{{ asset('layout_style/jquery_confirm/script.js') }}"></script>
    <script src="{{ asset('layout_style/jquery_confirm/popup.js') }}"></script>

    <script src="{{ asset('layout_style/js/circle-progress.min.js') }}"></script>
    <script src="{{ asset('layout_style/js/jquery.waypoints.js') }}"></script>
    <script src="{{ asset('layout_style/js/jquery.counterup.min.js') }}"></script>

    <script src="{{ asset('layout_style/cdn_scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js') }}"></script>
    <script src="{{ asset('layout_style/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ asset('layout_style/plugins/apexchart/chart-data.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script>
        //Open dropdown when clicking on element
        $(document).on("click", "a[data-dropdown='notificationMenu']", function (e) {
            e.preventDefault();

            var el = $(e.currentTarget);

            $("body").prepend(
                '<div id="dropdownOverlay" style="background: transparent; height:100%;width:100%;position:fixed;"></div>'
            );

            var container = $(e.currentTarget).parent();
            var dropdown = container.find(".dropdown");
            var containerWidth = container.width();
            var containerHeight = container.height();

            var anchorOffset = $(e.currentTarget).offset();

            dropdown.css({
                right: containerWidth / 2 + "px"
            });

            container.toggleClass("expanded");
        });

        //Close dropdowns on document click

        $(document).on("click", "#dropdownOverlay", function (e) {
            var el = $(e.currentTarget)[0].activeElement;

            if (typeof $(el).attr("data-dropdown") === "undefined") {
                $("#dropdownOverlay").remove();
                $(".dropdown-container.expanded").removeClass("expanded");
            }
        });

        //Dropdown collapsile tabs
        $(".notification-tab").click(function (e) {
            if ($(e.currentTarget).parent().hasClass("expanded")) {
                $(".notification-group").removeClass("expanded");
            } else {
                $(".notification-group").removeClass("expanded");
                $(e.currentTarget).parent().toggleClass("expanded");
            }
        });

        $(document).ready(function () {
            $('.select2').select2()

        });
    </script>
    {{--
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js"></script>


    @yield('scripts')
</body>

</html>