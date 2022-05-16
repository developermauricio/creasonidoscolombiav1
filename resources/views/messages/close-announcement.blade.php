<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <title>Cierre de Inscripción - {{ config('app.name', 'Laravel') }}</title>
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
            <div class="auth-wrapper auth-v1 px-2">
                <div class="auth-inner py-2">
                    <!-- Forgot Password v1 -->
                    <div class="card mb-0">
                        <div class="card-body">
                            <a href="#" class="brand-logo">
                                <img class="logo-header" width="180" src="{{ env('URL_IMG_LOGO') }}" alt="">
                            </a>

{{--                            <h4 class="card-title mb-1">El proceso de registro a finalizado 🔒</h4>--}}
{{--                            <p class="card-text mb-2">Agradecemos a todos por la masiva participación en esta fase de Creasonidos Colombia.</p>--}}

{{--                            <div class="mb-2">--}}
{{--                                <strong>Si ya tiene una cuenta, puede seguir el proceso dando clic en el boton de iniciar sesión con las credenciales de acceso enviadas a su correo electrónico.</strong>--}}
{{--                            </div>--}}

{{--                            <a href="/login" class="btn btn-primary btn-block pt-1" type="submit" tabindex="2">Iniciar Sesión</a>--}}

{{--                            <p class="text-center mt-2">--}}
{{--                                <a href="https://www.creasonidos.com/"> <i data-feather="chevron-left"></i> Volver a www.creasonidos.com--}}
{{--                                </a>--}}
{{--                            </p>--}}

{{--                            <h4 class="card-title mb-1">¡Hola! El tiempo de INSCRIPCIÓN ya ha terminado</h4>--}}

                            <h4 class="card-text mb-2">¡ El tiempo de <strong>inscripción se ha TERMINADO !</strong> Muchas gracias por inscribir tu música.</h4>
                            <div style="display: flex; justify-content: center">
{{--                                <img width="100" src="/images/fiesta.gif" alt="">--}}
                            </div>
                            <p>Ahora viene el proceso interno de curaduría y selección de los 100 ganadores. </p>
                            <h4 class="card-text mb-2">¡ Felicitaciones, y muchos éxitos a todos !</h4>
{{--                            <div class="mb-2">--}}
{{--                                <p style="font-size: 0.8rem">Las personas que lograron hacer la inscripción, aún pueden registrar su propuesta musical hasta el 30 de mayo dando clic en el botón "iniciar sesión".</p>--}}
{{--                            </div>--}}

{{--                            <a href="/login" class="btn btn-primary btn-block pt-1" type="submit" tabindex="2">Iniciar Sesión</a>--}}

                            <p class="text-center mt-2">
                                <a href="https://www.creasonidos.com/"> <i data-feather="chevron-left"></i> Volver a www.creasonidos.com
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
