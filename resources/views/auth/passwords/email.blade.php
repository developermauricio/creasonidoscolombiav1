<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <title>Recuperar Contraseña - {{ config('app.name', 'Laravel') }}</title>
{{--    <link rel="apple-touch-icon" href="/app-assets/images/ico/apple-icon-120.png">--}}
{{--    <link rel="shortcut icon" type="image/x-icon" href="/app-assets/images/ico/favicon.ico">--}}
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
          rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/themes/semi-dark-layout.css">

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
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu blank-page navbar-floating footer-static  " data-open="hover"
      data-menu="horizontal-menu" data-col="blank-page">
<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            @if (session('status'))
                <div class="alert alert-success p-2" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="auth-wrapper auth-v1 px-2">
                <div class="auth-inner py-2">
                    <!-- Forgot Password v1 -->
                    <div class="card mb-0">
                        <div class="card-body">
                            <a href="#" class="brand-logo">
                                <img class="logo-header" width="180" src="{{ env('URL_IMG_LOGO') }}" alt="">
                            </a>

                            <h4 class="card-title mb-1">¿Has olvidado tu contraseña? 🔒</h4>
                            <p class="card-text mb-2">Ingrese su correo electrónico y le enviaremos instrucciones para
                                restablecer su contraseña</p>

                            <form class="auth-forgot-password-form mt-2" method="POST"
                                  action="{{ route('password.email') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="forgot-password-email" class="form-label">Corre electrónico</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                           id="forgot-password-email" name="email" placeholder="john@example.com"
                                           value="{{ old('email') }}" aria-describedby="forgot-password-email"
                                           tabindex="1" autofocus/>
                                </div>
                                @error('email')
                                <span class="text-danger mb-4" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                @enderror
                                <button class="btn btn-primary btn-block pt-1" type="submit" tabindex="2">Recuperar Contraseña</button>
                            </form>

                            <p class="text-center mt-2">
                                <a href="/login"> <i data-feather="chevron-left"></i> Volver al inicio de sesión
                                </a>
                            </p>
                        </div>
                    </div>
                    <!-- /Forgot Password v1 -->
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
<script src="/app-assets/vendors/js/ui/jquery.sticky.js"></script>
<script src="/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="/app-assets/js/core/app-menu.js"></script>
<script src="/app-assets/js/core/app.js"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="/app-assets/js/scripts/pages/page-auth-forgot-password.js"></script>
<!-- END: Page JS-->

<script>
    $(window).on('load', function () {
        if (window.feather) {
            window.feather.replace({
                width: 14,
                height: 14
            });
        }
    })
</script>
</body>
<!-- END: Body-->

</html>
