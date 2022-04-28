<!--=====================================
		LOGO
======================================-->
{{--@if(auth()->user()->roles[0]->name == "Aspirante" || auth()->user()->roles[0]->name == "Curador" )--}}
{{--<div class="navbar-header d-xl-block d-block">--}}
{{--    <ul class="nav navbar-nav">--}}
{{--        <li class="nav-item">--}}
{{--            <a class="navbar-brand" href="#">--}}
{{--                <img class="logo-header" width="110" src="{{ env('URL_IMG_LOGO') }}" alt="">--}}
{{--            </a>--}}
{{--        </li>--}}
{{--    </ul>--}}
{{--</div>--}}
{{--@endif--}}
<div class="navbar-header d-xl-block d-none">
    <ul class="nav navbar-nav">
        <li class="nav-item">
            <a class="navbar-brand" href="#">
                <img class="{{ auth()->user()->roles[0]->name == "Aspirante" ? 'logo-header-aspirant' : 'logo-header'}}" width="90" src="{{ env('URL_IMG_LOGO') }}" alt="">
            </a>
        </li>
    </ul>
</div>
<!--=====================================
		INFORMACION DE USUARIO LOGUEADO
======================================-->
<div class="navbar-container d-flex content">
    @if(auth()->user()->roles[0]->name == "Administrador")

    <div class="bookmark-wrapper d-flex align-items-center">
        <ul class="nav navbar-nav d-xl-none">
            <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon" data-feather="menu"></i></a></li>
        </ul>
    </div>
    @endif
    <ul class="nav navbar-nav align-items-center ml-auto">
{{--        <li class="nav-item">--}}
{{--            <a data-toggle="modal" data-target="modal-changed-password" class="nav-link dropdown-toggle dropdown-user-link" href="javascript:void(0);"--}}
{{--               aria-haspopup="true" aria-expanded="false">--}}
{{--                @auth()--}}
{{--                    <div class="user-nav d-sm-flex d-none">--}}
{{--                            <span class="user-name font-weight-bolder"><i style="width: 24px; height: 24px;" data-feather='user'></i></span>--}}
{{--                        <span--}}
{{--                            class="user-name font-weight-bolder">{{ auth()->user()->name }} {{ auth()->user()->last_name }}</span>--}}
{{--                        <span class="user-status">Clic para mostrar mas info</span>--}}
{{--                    </div>--}}
{{--                @endauth--}}
{{--            </a>--}}
{{--        </li>--}}

        <li class="nav-item dropdown dropdown-user">
            <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @auth()
                    <div class="user-nav d-sm-flex d-none">
                        <span class="user-name font-weight-bolder"><i style="width: 24px; height: 24px;" data-feather='user'></i></span>
                        {{--                        <span--}}
                        {{--                            class="user-name font-weight-bolder">{{ auth()->user()->name }} {{ auth()->user()->last_name }}</span>--}}
                        {{--                        <span class="user-status">Clic para mostrar mas info</span>--}}
                    </div>
                @endauth
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                <h5 class="pl-2 pt-1">Sr(a) {{ auth()->user()->name }} {{ auth()->user()->last_name }}</h5>
                <a class="dropdown-item" href="#" id="modal-changed-password"><i data-feather='lock'></i> Cambiar Contraseña</a>
                <a class="dropdown-item" target="_blank" href="https://www.creasonidos.com/contactanos"><i data-feather='help-circle'></i> ¿Necesita ayuda?</a>
                <a class="dropdown-item" target="_blank" href="https://www.creasonidos.com/wp-content/uploads/2022/04/1.-TERMINOS-DE-PARTICIPACION-CREASONIDOS-2022.pdf"><i data-feather='info'></i> Términos generales de participación</a>
                {{--                                <a class="dropdown-item" href="app-email.html"><i class="mr-50" data-feather="mail"></i> Inbox</a>--}}
                {{--                                <a class="dropdown-item" href="app-todo.html"><i class="mr-50" data-feather="check-square"></i> Task</a>--}}
                {{--                                <a class="dropdown-item" href="app-chat.html"><i class="mr-50" data-feather="message-square"></i> Chats</a>--}}
                {{--                                <div class="dropdown-divider"></div>--}}
                {{--                                <a class="dropdown-item" href="page-account-settings.html"><i class="mr-50" data-feather="settings"></i> Settings</a>--}}
                {{--                                <a class="dropdown-item" href="page-pricing.html"><i class="mr-50" data-feather="credit-card"></i> Pricing</a>--}}
                {{--                                <a class="dropdown-item" href="page-faq.html"><i class="mr-50" data-feather="help-circle"></i> FAQ</a>--}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item" href="#" style="width: 100% !important;">
                        <i class="mr-50" data-feather="power"></i>
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </li>
    </ul>
</div>
<change-password-component id="open-modal-change-password"></change-password-component>
@push('js')
    <script>
        $(function () {
            $( "#modal-changed-password" ).click(function() {
                $('#openModalChangePassword').val('hola').click();
            });
        })
    </script>
@endpush

<!--=====================================
		LOGO
======================================-->
{{--<div class="navbar-header d-xl-block d-none">--}}
{{--    <ul class="nav navbar-nav">--}}
{{--        <li class="nav-item">--}}
{{--            <a class="navbar-brand" href="#">--}}
{{--                <img class="logo-header" width="110" src="{{ env('URL_IMG_LOGO') }}" alt="">--}}
{{--            </a>--}}
{{--        </li>--}}
{{--    </ul>--}}
{{--</div>--}}
{{--<div>--}}
{{--    <img class="" width="110" src="{{ env('URL_IMG_LOGO') }}" alt="">--}}
{{--</div>--}}

{{--<!--=====================================--}}
{{--		INFORMACION DE USUARIO LOGUEADO--}}
{{--======================================-->--}}
{{--<div class="navbar-container d-flex content">--}}
{{--    <ul class="nav navbar-nav align-items-center ml-auto">--}}
{{--        <li class="nav-item dropdown dropdown-user">--}}
{{--            <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);"--}}
{{--               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                @auth()--}}
{{--                    <div class="user-nav d-sm-flex d-none">--}}
{{--                        <span--}}
{{--                            class="user-name font-weight-bolder"><i data-feather='user'></i></span>--}}
{{--                        --}}{{--                        <span class="user-status">Clic para mostrar mas info</span>--}}
{{--                    </div>--}}
{{--                @endauth--}}
{{--            </a>--}}
{{--            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">--}}
{{--                <p class="pl-2 pt-1">{{ auth()->user()->name }} {{ auth()->user()->last_name }}</p>--}}
{{--                --}}{{--                <a class="dropdown-item" href="page-profile.html"><i class="mr-50" data-feather="user"></i> Profile</a>--}}
{{--                --}}{{--                <a class="dropdown-item" href="app-email.html"><i class="mr-50" data-feather="mail"></i> Inbox</a>--}}
{{--                --}}{{--                <a class="dropdown-item" href="app-todo.html"><i class="mr-50" data-feather="check-square"></i> Task</a>--}}
{{--                --}}{{--                <a class="dropdown-item" href="app-chat.html"><i class="mr-50" data-feather="message-square"></i> Chats</a>--}}
{{--                --}}{{--                <div class="dropdown-divider"></div>--}}
{{--                --}}{{--                <a class="dropdown-item" href="page-account-settings.html"><i class="mr-50" data-feather="settings"></i> Settings</a>--}}
{{--                --}}{{--                <a class="dropdown-item" href="page-pricing.html"><i class="mr-50" data-feather="credit-card"></i> Pricing</a>--}}
{{--                --}}{{--                <a class="dropdown-item" href="page-faq.html"><i class="mr-50" data-feather="help-circle"></i> FAQ</a>--}}
{{--                <form method="POST" action="{{ route('logout') }}">--}}
{{--                    @csrf--}}
{{--                    <button type="submit" class="dropdown-item" href="page-auth-login-v2.html"><i class="mr-50"--}}
{{--                                                                                                  data-feather="power"></i>--}}
{{--                        Cerrar Sesión--}}
{{--                    </button>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </li>--}}
{{--    </ul>--}}
{{--</div>--}}
