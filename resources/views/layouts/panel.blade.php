
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>MarcoPolo</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="/css/app.css">
    <link href="{{asset('css/libs.css')}}" rel="stylesheet">
    <script src="{{asset('js/libs.js')}}" type="text/javascript"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css" integrity="sha384-i1LQnF23gykqWXg6jxC2ZbCbUMxyw5gLZY6UiUS98LYV5unm8GWmfkIS6jqJfb4E" crossorigin="anonymous">

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- SEARCH FORM -->

        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar"  type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar">
                    <i class="fas fa-search"></i>
                </button>

            </div>
        </div>


    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{route('welcome')}}" class="brand-link">
            <img src="/images/logo.png" alt="LaraStart Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Marcopolo</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="/images/profile.png" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">
                        {{Auth::user()->name}}
                        <p>{{Auth::user()->role->name}}</p>
                    </a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->

                    @can('isAdminORDeveloper')
                    <li class="nav-item">
                        <router-link to="/panel/users" class="nav-link">
                            <i class="nav-icon fas fa-users blue"></i>
                            <p class="blue">
                                Users
                            </p>
                        </router-link>
                    </li>
                    @endcan
                    @can('isAdminORDeveloperORSalesPerson')
                    <li class="nav-item">
                        <router-link to="/panel/control" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt green"></i>
                            <p class="green">
                                Tags-Brands-Categories
                            </p>
                        </router-link>
                    </li>
                    @endcan

                    @can('isAdminORDeveloperORSalesPerson')
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-shopping-bag purple"></i>
                                <p class="purple">
                                    Product Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" style="display: none;">

                                <li class="nav-item">
                                    <router-link to="/panel/product_media" class="nav-link">
                                        <i class="nav-icon fas fa-file-upload orange"></i>
                                        <p class="orange">
                                            Media Upload
                                        </p>
                                    </router-link>
                                </li>

                                <li class="nav-item">
                                    <router-link to="/panel/product_add" class="nav-link">
                                        <i class="fas fa-plus nav-icon pink"></i>
                                        <p class="pink">Add</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/panel/product_view" class="nav-link">
                                        <i class="far fa-eye nav-icon teal"></i>
                                        <p class="teal">View</p>
                                    </router-link>
                                </li>
                            </ul>
                        </li>

                    @endcan



                    @can('isDeveloper')
                        <li class="nav-item">
                            <router-link to="/panel/developer" class="nav-link">
                                <i class="nav-icon fas fa-cogs yellow"></i>
                                <p class="yellow">
                                    Developer
                                </p>
                            </router-link>
                        </li>
                    @endcan


                    <li class="nav-item">

                        <a class="nav-link" href="{{ url('/clogout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="nav-icon fas fa-power-off red"></i>
                            <p class="red">{{ __('Logout') }}</p>
                        </a>

                        <form id="logout-form" action="{{ url('/clogout') }}" method="GET" style="display: none;">
                            @csrf
                        </form>

                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <!-- All of the components are rendered here... -->
                <router-view></router-view>
{{--                <vue-progress-bar></vue-progress-bar>--}}
            </div>
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

@auth
    <script>
        window.user_role_name =@json(auth()->user()->role->name)
    </script>
@endauth

<script src="/js/app.js" type="text/javascript"></script>
@yield('scripts')
</body>
</html>
