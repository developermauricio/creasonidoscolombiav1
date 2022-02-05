<!--=====================================
		LOGO
======================================-->
<div class="navbar-header d-xl-block d-none">
    <ul class="nav navbar-nav">
        <li class="nav-item">
            <a class="navbar-brand" href="#">
                <img class="logo-header" width="180" src="{{ env('URL_IMG_LOGO') }}" alt="" >
            </a>
        </li>
    </ul>
</div>

<!--=====================================
		INFORMACION DE USUARIO LOGUEADO
======================================-->
<div class="navbar-container d-flex content">
    <ul class="nav navbar-nav align-items-center ml-auto">
        <li class="nav-item dropdown dropdown-user">
            <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="user-nav d-sm-flex d-none">
                    <span class="user-name font-weight-bolder">{{ auth()->user()->name }} {{ auth()->user()->last_name }}</span>
                    <span class="user-status">Clic para mostrar mas info</span>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
{{--                <a class="dropdown-item" href="page-profile.html"><i class="mr-50" data-feather="user"></i> Profile</a>--}}
{{--                <a class="dropdown-item" href="app-email.html"><i class="mr-50" data-feather="mail"></i> Inbox</a>--}}
{{--                <a class="dropdown-item" href="app-todo.html"><i class="mr-50" data-feather="check-square"></i> Task</a>--}}
{{--                <a class="dropdown-item" href="app-chat.html"><i class="mr-50" data-feather="message-square"></i> Chats</a>--}}
{{--                <div class="dropdown-divider"></div>--}}
{{--                <a class="dropdown-item" href="page-account-settings.html"><i class="mr-50" data-feather="settings"></i> Settings</a>--}}
{{--                <a class="dropdown-item" href="page-pricing.html"><i class="mr-50" data-feather="credit-card"></i> Pricing</a>--}}
{{--                <a class="dropdown-item" href="page-faq.html"><i class="mr-50" data-feather="help-circle"></i> FAQ</a>--}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                <button type="submit" class="dropdown-item" href="page-auth-login-v2.html"><i class="mr-50" data-feather="power"></i> Cerrar Sesión</button>
                </form>
            </div>
        </li>
    </ul>
</div>
