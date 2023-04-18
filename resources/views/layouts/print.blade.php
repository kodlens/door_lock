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


    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style lang="css">
        @page{
            size: 8.5in 13in; /* specify the custom page size */
            margin: 1cm; /* specify the margins for the printed page */
        }

        @media print{
            .hide-print{
                display: none;
            }
        }

        .print-container{
            margin: 25px;
        }

        .p-header{
            text-align: center;
        }
        .text-header{
            font-weight: bold;
        }

        .table-students{
            width: 600px;
            margin: auto;
        }
        .table-students > table{
            margin: 20px auto;
        }

        .table-students tr > th {
            padding: 10px;
            margin: 5px;
            border: 1px solid gray;
        }

        .table-students tr > td {
            padding: 10px;
            margin: 5px;
            border: 1px solid gray;
        }

    </style>

</head>
<body>
    <div id="app">
        <div>
            @yield('content')

        </div>


    </div>


    <script>
        
    </script>


</body>
</html>
