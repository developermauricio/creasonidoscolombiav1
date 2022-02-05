<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
{{--    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">--}}
{{--    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">--}}
{{--    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">--}}
    <meta name="author" content="CREA SONIDOS COLOMBIA">
    <title>{{ config('app.name') }} | @yield('title')</title>
    <link rel="apple-touch-icon" href="/app-assets/images/ico/apple-icon-120.png">
{{--    <link rel="shortcut icon" type="image/x-icon" href="/app-assets/images/ico/favicon.ico">--}}

<!--=====================================
    ESTILOS CSS
======================================-->
    @include('partials.assets.styles')
    @stack('css')

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu  navbar-floating footer-fixed" data-open="hover" data-menu="horizontal-menu" data-col="">

<!-- BEGIN: Header-->
<nav class="header-navbar navbar-expand-lg navbar navbar-fixed align-items-center navbar-shadow navbar-brand-center" data-nav="brand-center">
    <!--=====================================
		 HEADER
    ======================================-->
    @include('partials.header.header-principal')
</nav>
<!-- END: Header-->


<!-- BEGIN: Main Menu-->
    <!--=====================================
		 MENU PRINCIPAL
    ======================================-->
{{--@include('partials.menu.menu-prinicipal')--}}
<!-- END: Main Menu-->

<!-- BEGIN: Content-->
<div class="app-content content" id="app">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body">
            @yield('content')
        </div>
    </div>
</div>
<!-- END: Content-->

{{--<div class="sidenav-overlay"></div>--}}
{{--<div class="drag-target"></div>--}}
<div class="pb-5">
    <div class="pb-5">

    </div>
</div>
<!-- BEGIN: Footer-->
<footer class="footer footer-light">
    <p class="clearfix mb-0">
        <span class="float-md-left d-block d-md-inline-block mt-25">
            Con el apoyo de:
            <img class="ml-2" width="155" src="/img/logo-fundacion-yuri.png" alt="">
            <img class="ml-2" width="150" src="/img/logo-ecopetrol.png" alt="" style="margin-top: -1.5rem;">
            <img class="ml-2" width="150" src="/img/logo-bancolombia.png" alt="" style="margin-top: -0.6rem;">
        </span>
        <span class="float-md-right d-none d-md-block" style="font-size: 0.8rem !important; margin-top: 1rem;">
            Crea Sonidos Colombia 2022 © Todos los derechos reservados.
        </span>
    </p>
</footer>
<button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
<!-- END: Footer-->


<!-- BEGIN: Vendor JS-->
<script src="/app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="/app-assets/vendors/js/ui/jquery.sticky.js"></script>
{{--<script src="/app-assets/vendors/js/charts/apexcharts.min.js"></script>--}}
{{--<script src="/app-assets/vendors/js/extensions/toastr.min.js"></script>--}}
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="/app-assets/js/core/app-menu.js"></script>
<script src="/app-assets/js/core/app.js"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
{{--<script src="/app-assets/js/scripts/pages/dashboard-ecommerce.js"></script>--}}
<script src="{{ asset('js/app.js') }}"></script>
@stack('js')
<!-- END: Page JS-->

<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
</script>
</body>
<!-- END: Body-->

</html>
