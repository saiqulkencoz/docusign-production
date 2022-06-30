<!DOCTYPE html>
<html lang="en">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>DocuSign</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- site icon -->
    <link rel="icon" type="image/x-icon" href="{{asset('master/images/favicon.ico')}}">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="{{ asset('master/css/bootstrap.min.css') }}" />
    <!-- site css -->
    <link rel="stylesheet" href="{{ asset('master/style.css') }}" />
    <!-- responsive css -->
    <link rel="stylesheet" href="{{ asset('master/css/responsive.css') }}" />
    <!-- color css -->
    {{-- <link rel="stylesheet" href="{{asset('master/css/colors.css')}}" /> --}}
    <!-- select bootstrap -->
    <link rel="stylesheet" href="{{ asset('master/css/bootstrap-select.css') }}" />
    <!-- scrollbar css -->
    <link rel="stylesheet" href="{{ asset('master/css/perfect-scrollbar.css') }}" />
    <!-- custom css -->
    <link rel="stylesheet" href="{{ asset('master/css/custom.css') }}" />
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
        integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="dashboard dashboard_1">
    <div class="full_container">
        <div class="inner_container">
            <!-- Sidebar  -->
            @include('master_adm.sidebar')
            <!-- end sidebar -->
            <!-- right content -->
            <div id="content">
                <!-- topbar -->
                @include('master_adm.topbar')
                <!-- end topbar -->
                <!-- dashboard inner -->
                @yield('content')
                <!-- end dashboard inner -->
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="{{ asset('master/js/jquery.min.js') }}"></script>
    <script src="{{ asset('master/js/popper.min.js') }}"></script>
    <script src="{{ asset('master/js/bootstrap.min.js') }}"></script>
    <!-- wow animation -->
    <script src="{{ asset('master/js/animate.js') }}"></script>
    <!-- select country -->
    <script src="{{ asset('master/js/bootstrap-select.js') }}"></script>
    <!-- owl carousel -->
    <script src="{{ asset('master/js/owl.carousel.js') }}"></script>
    <!-- chart js -->
    <script src="{{ asset('master/js/Chart.min.js') }}"></script>
    <script src="{{ asset('master/js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('master/js/utils.js') }}"></script>
    <script src="{{ asset('master/js/analyser.js') }}"></script>
    <!-- nice scrollbar -->
    <script src="{{ asset('master/js/perfect-scrollbar.min.js') }}"></script>
    <script>
        var ps = new PerfectScrollbar('#sidebar');
    </script>
    <!-- custom js -->
    <script src="{{ asset('master/js/custom.js') }}"></script>
    <script src="{{ asset('master/js/chart_custom_style1.js') }}"></script>
    @yield('footer')
</body>

</html>
