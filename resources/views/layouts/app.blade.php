<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
{{--    <link rel="dns-prefetch" href="//fonts.gstatic.com">--}}
{{--    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">--}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        
        <b-navbar>
            <template #brand>
                <b-navbar-item>
                    <h1 class="title is-4">ADMINISTRATOR</h1>
                </b-navbar-item>
            </template>

            <template #start>


            </template>

            <template #end>
                <b-navbar-item href="/home" 
                    class="{{ (request()->is('home*')) ? 'active' : '' }}">
                    Home
                </b-navbar-item>

                <b-navbar-item href="/academic-years"
                    class="{{ (request()->is('academic-years*')) ? 'active' : '' }}">
                    Academic Year
                </b-navbar-item>

                <b-navbar-item href="/doors"
                    class="{{ (request()->is('doors*')) ? 'active' : '' }}">
                    Door
                </b-navbar-item>

                <b-navbar-item href="/schedules"
                    class="{{ (request()->is('schedules*')) ? 'active' : '' }}">
                    Schedule
                </b-navbar-item>

                {{-- <b-navbar-item href="/faculty"
                    class="{{ (request()->is('faculty*')) ? 'active' : '' }}">
                    Faculty
                </b-navbar-item> --}}
                
                <b-navbar-item href="/users"
                    class="{{ (request()->is('users*')) ? 'active' : '' }}">
                    Users
                </b-navbar-item>
                
                <!-- <b-navbar-item href="/about">
                    ABOUT
                </b-navbar-item> -->

                

                <b-navbar-item tag="div">
                    <div class="buttons">
                        <form id="logout" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="button has-text-weight-bold is-danger">
                                <b-icon icon="logout"></b-icon> &nbsp; LOG OUT
                            </button>
                        </form>
                    </div>
                </b-navbar-item>
            </template>
        </b-navbar>

        

        <div>
            @yield('content')
    
        </div>


    </div>


    <script>
        
    </script>


</body>
</html>
