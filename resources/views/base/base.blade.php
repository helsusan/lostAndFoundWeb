<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>LostAndFound</title>
      @vite('resources/css/app.css')
      <style>
          body {
              background-color: #E4F2F5;
          }
      </style>
  </head>
  <body>
    @include('components.swallalert')
    <div class="container m-auto">
        @yield('content')
    </div>
  </body>
</html>