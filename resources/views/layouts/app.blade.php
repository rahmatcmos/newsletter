<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title or config('app.name') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('component/font-awesome/css/font-awesome.min.css') }}">

    @stack('css')

    <!-- Scripts -->
    <script>
        window.Laravel =                                                                                                                                                                                                                                                                                                                         <?php echo json_encode([
                                                                                                                                                                                                                                                                                                                                 'csrfToken' => csrf_token(),
                                                                                                                                                                                                                                                                                                                         ]); ?>
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li class="{{ request()->is('/') ? 'active' : '' }}"><a href="{{ route('index') }}">Home</a></li>
                            <li class="{{ request()->is('about') ? 'active' : '' }}"><a href="{{ route('about') }}">About</a></li>
                            <li class="{{ request()->is('newsletter') ? 'active' : '' }}"><a href="{{ route('newsletter.index') }}">Newsletter</a></li>
                            <li class="{{ request()->is('contact') ? 'active' : '' }}"><a href="{{ route('contact') }}">Contact</a></li>
                            <li class="{{ request()->is('register') ? 'active' : '' }}"><a href="{{ url('/register') }}">Register</a></li>
                            <li class="{{ request()->is('login') ? 'active' : '' }}"><p class="navbar-btn"><a href="{{ url('/login') }}" class="btn btn-primary"><i class="fa fa-lock"></i> Login</a></p></li>
                        @else
                            <li><a href="{{ route('home') }}">About</a></li>
                            <li><a href="{{ route('admin.list') }}">@lang('newsletter.lists.title')</a></li>
                            <li>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    @lang('newsletter.subscribers.title') <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('admin.subscriber') }}">@lang('newsletter.subscribers.list')</a></li>
                                    <li><a href="{{ route('admin.subscriber.create') }}">@lang('newsletter.subscribers.create')</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Newsletters <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="">Create &amp; Send Newsletters</a></li>
                                    <li><a href="{{ route('admin.newsletter') }}">Newsletter Lists</a></li>
                                    <li><a href="">Templates</a></li>
                                    <li><a href="{{ route('admin.reason') }}">Unsubscribe Reason</a></li>
                                </ul>
                            </li>
                            <li class="{{ request()->is('admin/user') ? 'active' : '' }}"><a href="{{ route('admin.user') }}">@lang('user.title')</a></li>
                            <li class="{{ request()->is('admin/setting') ? 'active' : '' }}"><a href="{{ route('admin.setting') }}">Settings</a></li>
                            <li class="dropdown {{ request()->is('admin/user/*') ? 'active' : '' }}">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                   <i class="fa fa-user fa-fw"></i> {{ Auth::user()->name }} ({{ ucwords(auth()->user()->group )}}) <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ route('admin.user.profile') }}">@lang('user.profile')</a></li>
                                    <li><a href="">@lang('user.changePassword')</a></li>
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            @lang('user.logout')
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
    @stack('js')
    @stack('script')
</body>
</html>
