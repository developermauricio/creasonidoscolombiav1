<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    {{--    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">--}}
    {{--    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">--}}
    <meta name="author" content="CREASONIDOS COLOMBIA">
    <title>{{ config('app.name') }} | @yield('title')</title>
    <link rel="apple-touch-icon" href="/app-assets/images/ico/apple-icon-120.png">
    {{--    <link rel="shortcut icon" type="image/x-icon" href="/app-assets/images/ico/favicon.ico">--}}

<!--=====================================
    ESTILOS CSS
======================================-->
    @include('partials.assets.styles')
    @stack('css')
    <script>
        @auth()
            @if(auth()->user()->id)
            window.user_ìd = '{{ auth()->user()->id }}'
            window.role = '{{ auth()->user()->roles->first()->name }}'
        @endif
            @if( auth()->user()->aspirant)
            window.aspirant_id = '{{ auth()->user()->aspirant->id }}'
        @endif
            window.user_email = '{{ auth()->user()->email }}'
        window.user_name = '{{ auth()->user()->name }}'
        window.user_last_name = '{{ auth()->user()->last_name }}'
        window.user = '{{ auth()->user()->name }} {{ auth()->user()->last_name }}'
        @endauth
    </script>
    @if(env('APP_ENV') === 'production')
    <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-PXCL7MRG4N"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());

            gtag('config', 'G-PXCL7MRG4N');
        </script>
    @endif

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu  navbar-floating footer-fixed" data-open="hover"
      data-menu="horizontal-menu" data-col="">
<div id="app">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-lg navbar navbar-fixed align-items-center navbar-shadow navbar-brand-center"
         data-nav="brand-center">
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

@include('partials.menu.'.\App\User::navigation())
<!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content padding-bottom-audio">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="mb-2">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            <div class="alert-body">
                                {{ session('status') }}

                            </div>
                            @endif
                        </div>
                </div>

                @if (session('permission_denied'))
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">Atención</h4>
                        <div class="alert-body">
                            {{ session('permission_denied') }}
                        </div>
                    </div>
                @endif
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
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
    <!-- BEGIN: Footer-->
    <footer class="footer footer-light">
        Con el apoyo de:
        <div id="carousel-pause" class="carousel slide d-lg-none d-md-none text-center" data-ride="carousel"
             data-pause="hover">
            <ol class="carousel-indicators">
                <li data-target="#carousel-pause" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-pause" data-slide-to="1"></li>
                <li data-target="#carousel-pause" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                    <img class="img-fluid" width="200" src="/images/logo-fun-yuri-footer.png" alt="First slide"/>
                </div>
                <div class="carousel-item">
                    <img class="img-fluid" width="200" src="/images/logo-ecopetrol-footer.png" alt="Second slide"/>
                </div>
                <div class="carousel-item">
                    <img class="img-fluid" width="200" src="/images/logo-bancolombia-footer.png" alt="Third slide"/>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carousel-pause" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carousel-pause" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <div class="row footer-logos">
            <div class="col-12 col-md-1 col-lg-2 mt-2">
                <img class="" width="180" src="/images/logo-fundacion-yuri-buenaventura.png" alt="">
            </div>
            <div class="col-12 col-md-1 col-lg-2 mt-2">
                <img class="" width="140" src="/images/logo-ecopetrol.png" alt="" style="margin-top: -1.5rem;">
            </div>
            <div class="col-12 col-md-1 col-lg-2 mt-2">
                <img class="" width="175" src="/images/logo-bancolombia.png" alt="" style="margin-top: -0.010rem;">
            </div>
        </div>
        <span class="float-md-right d-none d-md-block" style="font-size: 0.8rem !important; margin-top: 1rem;">
            Creasonidos 2022 © Todos los derechos reservados.
        </span>
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
    <script src="/app-assets/js/scripts/extensions/ext-component-sweet-alerts.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    {{--<script src="/app-assets/js/scripts/pages/dashboard-ecommerce.js"></script>--}}
    <script src="/app-assets/js/scripts/pages/page-auth-reset-password.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
@stack('js')
<!-- END: Page JS-->

    <script>
        $(window).on('load', function () {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>
</div>
</body>
<!-- END: Body-->

</html>
