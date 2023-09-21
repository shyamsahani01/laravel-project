<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Bootstrap -->
    <link href="cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link href="{{ asset('/admin/assets/newTheme/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <script src="{{ asset('/admin/assets/newTheme/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>

    <!-- <link href="{{ asset('/admin/assets/newTheme/vendors/bootstrap-5/css/bootstrap.min.css')}}" rel="stylesheet">
    <script src="{{ asset('/admin/assets/newTheme/vendors/bootstrap-5/js/bootstrap.min.js')}}"></script> -->
    <!-- Font Awesome -->
    <link href="{{ asset('/admin/assets/newTheme/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <!-- <link href="{{ asset('/admin/assets/newTheme/vendors/fontawesome-free-6.4.2-web/css/fontawesome.min.css')}}" rel="stylesheet"> -->
    <!-- NProgress -->
    <link href="{{ asset('/admin/assets/newTheme/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset('/admin/assets/newTheme/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
    <!-- Datatables -->
    <!-- <link href="{{ asset('/admin/assets/newTheme/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('/admin/assets/newTheme/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('/admin/assets/newTheme/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('/admin/assets/newTheme/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('/admin/assets/newTheme/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet"> -->
    <!-- Custom Theme Style -->
    <link href="{{ asset('/admin/assets/newTheme/build/css/custom.min.css')}}" rel="stylesheet">
    <link href="{{ asset('/admin/assets/css/custom.css')}}" rel="stylesheet">
    <!-- jQuery -->
    <script src="{{ asset('/admin/assets/newTheme/vendors/jquery/dist/jquery.min.js')}}"></script>

    <link href="{{ asset('/admin/assets/newTheme/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet">
    <script src="{{ asset('/admin/assets/newTheme/vendors/select2/dist/js/select2.min.js')}}"></script>


    <!-- <link href="{{ asset('/admin/assets/newTheme/vendors/bootstrap-5/css/bootstrap.min.css')}}" rel="stylesheet">
    <script src="{{ asset('/admin/assets/newTheme/vendors/bootstrap-5/js/bootstrap.min.js')}}"></script> -->

        <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->


 </head>
 <!-- <body class="nav-md"> -->
<body class="nav-sm">
   <div  id="app" class="container body container_for_bt_5">
      <div class="main_container">
            @include('admin.layout.header')
            @include('admin.layout.navbar')
                <div class="right_col" role="main" id="right_col-content">
                    @yield('content')
                </div>
            @include('admin.layout.footer')
        </div>
    </div>
@include('admin.layout.script')
@yield('footer-scripts')
</body>
</html>
<style>
.disabled-menu {
  display: none !important;
}
</style>
 <script >
 $(".hr-menu").on("click", function functionName() {
   $(".hr-menu-ul").removeClass("disabled-menu")
//    $(".disabled-menu").removeClass("disabled-menu")
 })
 $(".py-menu").on("click", function functionName() {
   $(".py-menu-ul").removeClass("disabled-menu")
//    $(".disabled-menu").removeClass("disabled-menu")
 })
 $(".fg-menu").on("click", function functionName() {
   $(".fg-menu-ul").removeClass("disabled-menu")
 })

 $(".pd-menu").on("click", function functionName() {
   $(".pd-menu-ul").removeClass("disabled-menu")
 })

 $(".buying-menu").on("click", function functionName() {
   $(".buying-menu-ul").removeClass("disabled-menu")
 })

 $(".other-menu").on("click", function functionName() {
   $(".other-menu-ul").removeClass("disabled-menu")
 })

 $(".emporer-menu").on("click", function functionName() {
   $(".emporer-menu-ul").removeClass("disabled-menu")
 })

 </script>
