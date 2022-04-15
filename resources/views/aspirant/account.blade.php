<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="author" content="CREASONIDOS COLOMBIA">
    <title>{{ config('app.name') }} | Crear Cuenta</title>
    <link rel="apple-touch-icon" href="/app-assets/images/ico/apple-icon-120.png">
{{--    <link rel="shortcut icon" type="image/x-icon" href="/app-assets/images/ico/favicon.ico">--}}
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: PROPIOS MAIN CSS-->

    <link rel="stylesheet" type="text/css" href="/app-assets/css/main.css">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/extensions/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/themes/semi-dark-layout.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/plugins/extensions/ext-component-sweet-alerts.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/core/menu/menu-types/horizontal-menu.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/pages/page-auth.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
{{--    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">--}}
    <!-- END: Custom CSS-->
    @if(env('APP_ENV') === 'production')
    <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-PXCL7MRG4N"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-PXCL7MRG4N');
        </script>
    @endif
    <script type="text/javascript">

        function callbackThen(response){

            // read HTTP status

            console.log(response.status);

            // read Promise object

            response.json().then(function(data){

                console.log(data);

            });

        }

        function callbackCatch(error){

            console.error('Error:', error)

        }

    </script>

    {!! htmlScriptTagJsApi([

    'callback_then' => 'callbackThen',

    'callback_catch' => 'callbackCatch'

    ]) !!}

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu blank-page navbar-floating footer-static  " data-open="hover" data-menu="horizontal-menu" data-col="blank-page">
<!-- BEGIN: Content-->
<div class="app-content content" id="app">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="auth-wrapper auth-v2">
                <div class="auth-inner row m-0">
                    <!-- Brand logo-->
{{--                    <a class="brand-logo" href="javascript:void(0);">--}}
{{--                        <img width="150" src="{{ env('URL_IMG_LOGO') }}" alt="">--}}
{{--                        <h2 class="brand-text text-primary ml-1">Vuexy</h2>--}}
{{--                    </a>--}}
                    <!-- /Brand logo-->
                    <!-- Left Text-->
                    <div class="d-none d-lg-flex col-lg-8 align-items-center background-auth">
{{--                        <div class="w-100 d-lg-flex align-items-center justify-content-center px-5"><img class="img-fluid" src="/img/background-account.png" alt="Register V2" /></div>--}}
                    </div>
                    <!-- /Left Text-->
                    <!-- Register-->
                    <aspirant-account-create-component></aspirant-account-create-component>
                    <!-- /Register-->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->


<!-- BEGIN: Vendor JS-->
<script src="/app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="/app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
<script src="/app-assets/vendors/js/ui/jquery.sticky.js"></script>
<script src="/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="/app-assets/js/core/app-menu.js"></script>
<script src="/app-assets/js/core/app.js"></script>
<script src="/app-assets/js/scripts/extensions/ext-component-sweet-alerts.js"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="/app-assets/js/scripts/pages/page-auth-register.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
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
