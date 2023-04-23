<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Rakta Seva</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- <link rel="stylesheet" href="{{asset('site/css/app.css')}}"> -->
      <link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @yield('css') 
    <style>
        .nav-link{
            color:#fff;
        }
    </style>
     <link rel="stylesheet" type="text/css" href="{{asset('site/css/admintemplate.css')}}">
   <link rel="stylesheet" type="text/css" href="{{asset('admin/css/admin.css')}}">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light  shadow-sm" style="background-color:#940808;">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}" style="color:#fff">
                    Rakt Seva
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else

                            <li class="nav-item">
                                <a class="nav-link" href="{{route('home')}}" role="button">
                                    Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('user.getContribution')}}" role="button">
                                    Your Contribution
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('user.getSearchBloodGroup')}}" role="button">
                                    Search Blood Donor
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('user.getManageRequestBlood')}}" role="button">
                                    Requested Blood
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('user.getBloodRequest')}}" role="button">
                                    New Blood Group Request
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('user.getBloodbankList')}}" role="button">
                                    List of Blood banks
                                </a>
                            </li>


                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                    @if(Auth::user()->is_admin == 1)
                                        (Administrator)
                                    @else
                                        (User)
                                    @endif
                                </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
        <footer class="page-footer container-fluid">
            <hr>
            <h5 class="text-center">&copy; Rakt Seva. All Rights Reserved</h5>
        </footer>
        <script src="{{asset('custom.js')}}"></script>
</body>
</div>
@yield('js')
<script src="{{asset('custom.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 <script src="//cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
 <script>
        $(document).ready( function () {
    $('#myTable').DataTable({order:['desc']});

});
    </script>
</body>

</html>