<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Arsip Surat - @yield('title')</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Custom CSS Base -->
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f6f9; }
        .wrapper { display: flex; width: 100%; align-items: stretch; }
        #sidebar { min-width: 250px; max-width: 250px; background: #343a40; color: #fff; transition: all 0.3s; min-height: 100vh; position: fixed; z-index: 1030;}
        #sidebar .sidebar-header { padding: 20px; background: #212529; text-align: center; font-weight: bold; font-size: 1.2rem; border-bottom: 1px solid #4b545c;}
        #sidebar ul.components { padding: 10px 0; }
        #sidebar ul li a { padding: 12px 20px; font-size: 1.0rem; display: block; color: #c2c7d0; text-decoration: none; transition: 0.3s; }
        #sidebar ul li a i { width: 25px; text-align: center; margin-right: 5px; }
        #sidebar ul li a:hover { color: #fff; background: rgba(255,255,255,0.1); }
        #sidebar ul li.active > a { color: #fff; background: #007bff; border-radius: 0 25px 25px 0; margin-right: 15px;}
        .menu-section { padding: 15px 20px 5px; font-size: 0.75rem; text-transform: uppercase; color: #8fa0af; font-weight: 700; letter-spacing: 1px;}
        
        #content { width: calc(100% - 250px); margin-left: 250px; padding: 20px; min-height: 100vh; transition: all 0.3s; }
        .navbar { padding: 10px 20px; background: #fff; border-bottom: 1px solid #dee2e6; margin-bottom: 30px; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.02);}
        .card { border: none; box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2); border-radius: 0.25rem; }
        .card-header { background-color: transparent; border-bottom: 1px solid rgba(0,0,0,.125); padding: .75rem 1.25rem; position: relative; border-top-left-radius: .25rem; border-top-right-radius: .25rem; }
    </style>
</head>
<body>
    <div class="wrapper">
        @include('layouts.sidebar')
        <div id="content">
            @include('layouts.header')
            
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h4 mb-0 text-gray-800">@yield('title')</h2>
                    <div>
                        @yield('actions')
                    </div>
                </div>
                
                @yield('content')
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <!-- SweetAlert2 & Axios -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Setup Axios CSRF -->
    <script>
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom CRUD JS -->
    <script src="{{ asset('js/crud.js') }}"></script>
    @stack('scripts')
</body>
</html>
