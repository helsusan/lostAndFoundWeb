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

        <!-- jquery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">

        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
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
  <script>
        $(document).ready(function() {
            $('#Table').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                lengthChange: true,
                scrollX: true,
                autoWidth: false,
            });
        });

        document.getElementsByClassName("buttondelete").onclick = deleteRow;
        function deleteRow(button) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Deleted data cannot be reverted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                button.parentElement.submit();
            }
        });
    } 
    </script>
</html>