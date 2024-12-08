<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>Lost And Found</title>
      @vite(['resources/css/app.css', 'resources/js/app.js'])
      <style>
          body {
              background-color: #E4F2F5;
          }

          .found {
              background-color: #59b23a;
              color: white;
              border-radius: 5px;
              padding: 4px 8px;
          }

          .notfound {
              background-color: #80898f;
              color: white;
              border-radius: 5px;
              padding: 4px 8px;
          }
      </style>
      <!-- SweetAlert2 -->
       <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
  <body>
    @include('layouts.navigation')
    @include('components.swallalert')
    <div class="container m-auto">
        @yield('content')
    </div>
    @include('layouts.footer')
    @yield('home')
  </body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</html>