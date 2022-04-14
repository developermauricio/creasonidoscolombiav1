<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="author" content="CREASONIDOS COLOMBIA">
    <title>{{ config('app.name') }} | Iniciar Sesión</title>
    <link rel="apple-touch-icon" href="/app-assets/images/ico/apple-icon-120.png">
    {{--    <link rel="shortcut icon" type="image/x-icon" href="/app-assets/images/ico/favicon.ico">--}}
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
          rel="stylesheet">
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

            <div class="auth-wrapper auth-v2">
                <div class="auth-inner row m-0">
                    <!-- Brand logo-->
{{--                    <a class="brand-logo" href="javascript:void(0);">--}}
{{--                        <img width="200" src="{{ env('URL_IMG_LOGO') }}" alt="">--}}
{{--                    </a>--}}
                    <!-- /Brand logo-->
                    <!-- Left Text-->
                    <div class="d-none d-lg-flex col-lg-8 align-items-center background-auth">
{{--                        <div class="w-100 d-lg-flex align-items-center justify-content-center px-5"><img--}}
{{--                                class="img-fluid" src="/app-assets/images/pages/login-v2.svg" alt="Login V2"/></div>--}}
                    </div>
                    <!-- /Left Text-->
                    <!-- Login-->
                    <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5" style="margin-top: -12rem">

                        <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                            <div role="alert" aria-live="polite" aria-atomic="true" class="alert alert-success">
                                <div class="alert-body text-justify" id="text-alert-account" style="display: none">Su cuenta ha sido creada existosamente. Hemos enviado un correo electrónico
                                    con las credenciales de acceso para participar en
                                </div>
                            </div>
                            <h2 class="card-title font-weight-bold mb-1">Bienvenido! 👋</h2>
                            <p class="card-text mb-2">Por favor ingrese sus credenciales de acceso</p>
                            <form class="auth-login-form mt-2" action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label " for="login-email">Correo electrónico</label>
                                    <input class="form-control @error('email') @enderror" id="login-email" type="text" name="email"
                                           placeholder="john@example.com" value="{{ old('email') }}" aria-describedby="login-email" autofocus=""
                                           tabindex="1"/>
                                </div>

                                <div class="form-group">
                                    <div class="d-flex justify-content-between">
                                        <label for="login-password">Contraseña</label><a
                                            href="/password/reset"><small>Ólvido la
                                                contraseña?</small></a>
                                    </div>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input class="form-control @error('password')@enderror form-control-merge " id="login-password"
                                               type="password" name="password" placeholder="············"
                                               aria-describedby="login-password" tabindex="2"/>

                                        <div class="input-group-append"><span class="input-group-text cursor-pointer"><i
                                                    data-feather="eye"></i></span></div>


                                    </div>
                                </div>
                                @error('email')
                                <span class="text-danger pb-3" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span><br>
                                @enderror
                                @error('password')
                                <span class="text-danger pb-3" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                {{--                                <div class="form-group">--}}
                                {{--                                    <div class="custom-control custom-checkbox">--}}
                                {{--                                        <input class="custom-control-input" id="remember-me" type="checkbox" tabindex="3" />--}}
                                {{--                                        <label class="custom-control-label" for="remember-me"> Remember Me</label>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                                <button class="btn btn-primary btn-block" type="submit" tabindex="4">Ingresar</button>
                            </form>
                            <p class="text-center mt-2"><span>¿Aún no se encuentra registrado?</span><a href="/cuenta"><span>&nbsp;Registrarme</span></a>
                            </p>
                        </div>
                    </div>
                    <!-- /Login-->
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
<script src="/app-assets/js/scripts/pages/page-auth-login.js"></script>
<!-- END: Page JS-->
<script>
    $(function() {
       let email = localStorage.getItem('email')
       let message = localStorage.getItem('message')
        if (email || message){
            $('#login-email').val(email);
            $('#text-alert-account').text(message);
            $('#text-alert-account').css("display", "block");
            localStorage.clear()
        }

    });
</script>
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
</body>
<!-- END: Body-->

</html>
