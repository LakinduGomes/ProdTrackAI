<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Vendor Portal')</title>

    <!-- Bootstrap CSS (Choose ONE version, not both) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <!-- Other CSS Files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.css">
    <link rel="stylesheet" href="{{ asset('layout_style/css/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('layout_style/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('layout_style/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('layout_style/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('layout_style/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('layout_style/jquery_confirm/style.css') }}">
    <link rel="stylesheet" href="{{ asset('layout_style/css/bootstrap-datetimepicker.min.css') }}">
    
    <!-- Custom styles - load AFTER Bootstrap -->
    <link rel="stylesheet" type="text/css" href="{{ asset('layout_style/css/style.css?v=') . time() }}">
    <link rel="stylesheet" href="{{ asset('layout_style/css/my-style.css?v=') . time() }}">
    <link href="https://fonts.googleapis.com/css?family=Mulish:400,500,600,700&display=swap" rel="stylesheet">
    
    @stack('styles')
</head>
<body>
  
    
    <div class="main-wrapper">
        @yield('content')
    </div>
    

    
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('layout_style/plugins/moment/moment.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="{{ asset('layout_style/js/bootstrap-datetimepicker.min.js') }}"></script>
    
    <!-- Additional scripts -->
    @stack('scripts')
    
    <!-- Automatically open the modal if needed -->
    <script>
        $(document).ready(function() {
            // Initialize Bootstrap tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Auto-open modal if it exists
            var formModal = new bootstrap.Modal(document.getElementById('formModal'), {
                backdrop: 'static',
                keyboard: false
            });
            if (formModal) {
                formModal.show();
            }
        });
    </script>
</body>
</html>