<head>
    <!-- Meta Tags -->
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jampack - Admin CRM Dashboard Template</title>
    <meta name="description" content="A modern CRM Dashboard Template with reusable and flexible components for your SaaS web applications by hencework. Based on Bootstrap."/>
    
	<!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('admin/favicon.ico') }}">
    <link rel="icon" href="{{ asset('admin/favicon.ico') }}" type="image/x-icon">
	
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
	<!-- Daterangepicker CSS -->
    <link href="{{ asset('admin/vendors/daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css" />

	<!-- Data Table CSS -->
    <link href="{{ asset('admin/vendors/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/vendors/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />

	<!-- CSS -->
    <link href="{{ asset('admin/dist/css/style.css') }}" rel="stylesheet" type="text/css">
    
    <style>
        /* تأكد من أن Bootstrap يعمل بشكل صحيح */
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
            border: 1px solid rgba(0, 0, 0, 0.125) !important;
        }
        
        .btn {
            border-radius: 0.375rem !important;
        }
        
        .table {
            --bs-table-bg: transparent !important;
        }
        
        .badge {
            font-size: 0.75em !important;
        }
    </style>
</head>
@stack('styles')