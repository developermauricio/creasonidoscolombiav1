<div class="horizontal-menu-wrapper">
    <div class="header-navbar navbar-expand-sm navbar navbar-horizontal floating-nav navbar-light navbar-shadow menu-border container-xxl" role="navigation" data-menu="menu-wrapper" data-menu-type="floating-nav">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto">
                    <a class="navbar-brand" href="/">
                        <img class="" width="70" src="{{ env('URL_IMG_LOGO') }}" alt="" style="margin-left: 5rem">
                    </a>
                </li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <!-- Horizontal menu content-->
        <div class="navbar-container main-menu-content" data-menu="menu-container">
            <!-- include /includes/mixins-->
            <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">

                <!--=====================================
		            MENU DASHBOARD
                ======================================-->
                <li class="{{request()->is('dashboard') ? 'active' : '' }}" data-menu=""><a class="dropdown-item d-flex align-items-center" href="{{ route('reports.dashboard.page') }}" data-i18n="Leaflet Maps"><i data-feather='bar-chart'></i><span data-i18n="Dashboard">Dashboard</span></a>
                </li>

                <li class="{{request()->is('users') ? 'active' : '' }}"><a class="dropdown-item d-flex align-items-center" href="{{ route('users.admin.page') }}" data-i18n="Leaflet Maps"><i data-feather='users'></i><span data-i18n="Dashboard">Usuarios</span></a>
                </li>
                <li class="{{request()->is('subsanador') ? 'active' : '' }}"><a class="dropdown-item d-flex align-items-center" href="{{ route('subsanador.projects.page') }}" data-i18n="Leaflet Maps"><i data-feather='users'></i><span data-i18n="Dashboard">Subsanar</span></a>
                </li>


{{--                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link d-flex align-items-center" href="index.html" data-toggle="dropdown"><i data-feather="home"></i><span data-i18n="Dashboards">Dashboard</span></a>--}}
{{--                    <ul class="dropdown-menu">--}}
{{--                        <li data-menu=""><a class="dropdown-item d-flex align-items-center" href="dashboard-analytics.html" data-toggle="dropdown" data-i18n="Analytics"><i data-feather="activity"></i><span data-i18n="Analytics">Analytics</span></a>--}}
{{--                        </li>--}}
{{--                        <li class="active" data-menu=""><a class="dropdown-item d-flex align-items-center" href="dashboard-ecommerce.html" data-toggle="dropdown" data-i18n="eCommerce"><i data-feather="shopping-cart"></i><span data-i18n="eCommerce">eCommerce</span></a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
                <!--=====================================
		            MENU 2
                ======================================-->
{{--                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link d-flex align-items-center" href="#" data-toggle="dropdown"><i data-feather="bar-chart-2"></i><span data-i18n="Charts &amp; Maps">Charts &amp; Maps</span></a>--}}
{{--                    <ul class="dropdown-menu">--}}
{{--                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item d-flex align-items-center dropdown-toggle" href="#" data-toggle="dropdown" data-i18n="Charts"><i data-feather="pie-chart"></i><span data-i18n="Charts">Charts</span></a>--}}
{{--                            <ul class="dropdown-menu">--}}
{{--                                <li data-menu=""><a class="dropdown-item d-flex align-items-center" href="chart-apex.html" data-toggle="dropdown" data-i18n="Apex"><i data-feather="circle"></i><span data-i18n="Apex">Apex</span></a>--}}
{{--                                </li>--}}
{{--                                <li data-menu=""><a class="dropdown-item d-flex align-items-center" href="chart-chartjs.html" data-toggle="dropdown" data-i18n="Chartjs"><i data-feather="circle"></i><span data-i18n="Chartjs">Chartjs</span></a>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
{{--                        </li>--}}
{{--                        <li data-menu=""><a class="dropdown-item d-flex align-items-center" href="maps-leaflet.html" data-toggle="dropdown" data-i18n="Leaflet Maps"><i data-feather="map"></i><span data-i18n="Leaflet Maps">Leaflet Maps</span></a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
            </ul>
        </div>
    </div>
</div>
