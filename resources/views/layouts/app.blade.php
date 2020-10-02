<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Argon Dashboard') }}</title>
        <!-- Favicon -->
        <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Icons -->
        <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
        <script>

            window.MY_PROJECT = {
                category_store: "{{ route('category.store') }}"
            };
        </script>
    </head>
    <body class="{{ $class ?? '' }}">
        @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @include('layouts.navbars.sidebar')
        @endauth
        
        <div class="main-content">
            @include('layouts.navbars.navbar')
            @yield('content')
        </div>


        <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <!-- Argon JS -->
        <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        <!-- flatpickr JS -->
        <script src="{{ asset('argon') }}/js/flatpickr.js"></script>
        <!-- Argon JS -->
        <script  type="text/javascript" src="{{ URL::asset('argon') }}/js/crud.js"></script>
        <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        
        @stack('js')

        {{-- <div href="navbar-examples1">
             
        </div> --}}

        <script>
            // Toggle Search Form
                $(document).ready(function() {
                    
                    var currnet  =  "{{ url()->current()  }}";
                    var matching = $('.nav-link').filter(function(){
                        return $(this).attr('href') == currnet
                    });
                    matching.addClass('bg-primary text-white');
            
            
                    var isactive = $( ".show-test" ).find('.nav-link').filter(function(){
                        return $(this).attr('href') == currnet
                    });
            
                    isactive.closest(".show-test").addClass('show');
                    var show = isactive.closest(".show-test").attr('id');
                    $("[data-value="+show+"]").attr('aria-expanded', 'true');
            
                });
            </script>
    </body>
</html>
