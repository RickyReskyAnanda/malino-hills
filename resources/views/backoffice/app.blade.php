<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="base-url" content="{{ url('/') }}">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('office/assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('office/assets/img/favicon.png') }}">
    @viteReactRefresh
    @vite('resources/js/app.jsx')
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('office/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('office/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <link href="{{ asset('office/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('office/assets/css/soft-ui-dashboard.css?v=1.0.7') }}" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>

<body class="g-sidenav-show  bg-gray-100">
    <div id="app"></div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</body>
</html>