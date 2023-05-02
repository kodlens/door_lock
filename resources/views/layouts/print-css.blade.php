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

    <style>

        @page{
            size: 8.5 13in
        }

        .print-caontainer{
            margin: 0;
            padding: 0;
        }

        .att-table{
            margin: 10px auto;
            padding: 10px;
            font-size: .7em;
        }

        .att-table tr th{
            padding: 8px;
            /* border: 1px solid red; */
            border: 1px solid rgb(180, 180, 180);

        }
        .att-table tr td{
            padding: 5px;
            border: 1px solid rgb(180, 180, 180);
        }


        @media print {
            .att-table {
                page-break-inside: avoid;
            }
        }

    </style>

</head>
<body>
    <div id="app">
        
        

        <div>
            @yield('content')
    
        </div>


    {{-- </div> --}}


    <script>
        
    </script>


</body>
</html>
