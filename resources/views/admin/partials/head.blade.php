<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>Admin @if(isset($pageTitle)) | {{ $pageTitle }} @endif</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="shortcut icon" type="image/png" href="{{ asset('assets/admin/images/icon/favicon.ico') }}">

<!-- assets/css/bootstrap.min.css -->
<link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/css/themify-icons.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/css/metisMenu.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/css/slicknav.min.css') }}">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">

<!-- Start datatable css -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
<link href="https://cdn.datatables.net/rowreorder/1.2.3/css/rowReorder.bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">


<!-- amchart css -->
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<!-- others css -->
<link rel="stylesheet" href="{{ asset('assets/admin/css/typography.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/css/default-css.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/css/custom.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/css/responsive.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/css/sideMenu.css') }}">
<!-- modernizr css -->
<script src="{{ asset('assets/admin/js/vendor/modernizr-2.8.3.min.js') }}"></script>
<script src="//cdn.ckeditor.com/4.14.0/full/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
