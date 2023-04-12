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
                    <h1 class="title is-4">{{ strtoupper(Auth::user()->role) }}</h1>
                </b-navbar-item>
            </template>

            <template #start>


            </template>

            <template #end>
                <b-navbar-item href="/faculty-home" 
                    class="{{ (request()->is('faculty-home*')) ? 'active' : '' }}">
                    Home
                </b-navbar-item>

                <b-navbar-item href="/my-schedules"
                    class="{{ (request()->is('my-schedules*') || request()->is('my-schedule-student-list*')) ? 'active' : '' }}">
                    My Schedules
                </b-navbar-item>

                <b-navbar-item href="/my-students"
                    class="{{ (request()->is('my-students*')) ? 'active' : '' }}">
                    My Students
                </b-navbar-item>


                <b-navbar-item href="/attendances"
                    class="{{ (request()->is('attendances*')) ? 'active' : '' }}">
                    Attendance
                </b-navbar-item>
                


                <b-navbar-item href="/my-profile"
                    class="{{ (request()->is('user-profile*')) ? 'active' : '' }}">
                    {{ Auth::user()->fname }}
                </b-navbar-item>

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
