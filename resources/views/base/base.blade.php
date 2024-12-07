<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>Lost And Found</title>
      @vite('resources/css/app.css')
      <style>
          body {
              background-color: #E4F2F5;
          }
      </style>
      <!-- SweetAlert2 -->
       <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
  <body>
    @include('components.swallalert')
    <div class="container m-auto">
        @yield('content')
    </div>
  </body>
</html>