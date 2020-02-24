<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<base href="{{route('admin')}}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Movies, TV Shows and Live TV">
    

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'StreamApp') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Scripts -->
    <script type="text/javascript">
        window.url = <?php echo json_encode(url('/')); ?>;
    </script>


</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">

@include('layouts.header')
<div class="app-body">
@include('layouts.sidebar')
    <main id="app" class="main animated fadeIn">
@yield('content')
    </main>
</div>
@include('layouts.footer')

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>