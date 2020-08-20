<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MyShopAdmin | @yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  @include('admin.elemen.static_css')
  @yield('extra_css')
</head>

<body class="hold-transition skin-purple-light sidebar-mini">
  <div class="wrapper">
    <!-- Main Header -->
    <header class="main-header">

      <!-- Logo -->
      <a href="{{ route('beranda_admin') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>My</b>Shop</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>MySHop</b>Admin</span>
      </a>

      <!-- Header Navbar -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-fw"></i>Logout</a></li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </ul>
        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
          <div class="pull-left image">
            {{-- {{ Html::image(asset('storage/avatars/admin/'.session('foto_admin')), session('nama_admin'), [
                        'class' => 'img-circle'
                    ]) }} --}}
            <img src="{{Auth::user()->foto}}" alt="logo">
          </div>
          <div class="pull-left info">
            {{-- <p><a href="{{ route('profile_admin', [ 'id_admin' => session('id_admin')]) }}">{{ session('nama_admin') }}</a>
            </p> --}}
            <!-- Status -->
            @if (session('superadmin') == true)
            <span class="label bg-yellow">SUPERADMIN</span>
            @else
            <span class="label bg-blue">ADMIN</span>
            @endif
          </div>
        </div>

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
          <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
          </div>
        </form>

        <!-- /.search form -->
        @include('admin.elemen.sidebar')
      </section>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        @yield('content-header')
      </section>

      <!-- Main content -->
      <section class="@if(empty($invoice)) content container-fluid @else invoice @endif">
        @yield('content')
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    @yield('modal')

    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="pull-right hidden-xs">
        MyShopAdmin
      </div>
      <!-- Default to the left -->
      <strong>Copyright &copy; 2020 <a href="{{ route('beranda_admin') }}">MyShop</a>.</strong> All rights reserved.
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED JS SCRIPTS -->
  @include('admin.elemen.static_js')
  @yield('extra_js')
</body>

</html>