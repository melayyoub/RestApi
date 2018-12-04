<html lang="en-US">
@inject('getInfo', 'App\Http\Controllers\AdminsCont')

<head>
    @include('includes.headDash')
    @yield('meta')
    
</head>

<body class="">
    <div class="wrapper ">
        <div class="sidebar" data-color="orange">
            <div class="logo">
                 <a href="/" class="simple-text logo-mini">
                    <i class="fa fa-home"></i>
                </a>
                <a href="/dashboard" class="simple-text logo-normal">
                    {{ $getInfo->getValue('sitename') }}
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    @include('includes.dashLeftMenu')
                    
                </ul>
            </div>
        </div>
        <div class="main-panel">

            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-transparent  navbar-absolute bg-primary fixed-top">

                <div class="container-fluid">

                    <div class="navbar-wrapper">
                        <div class="navbar-toggle">
                            <button type="button" class="navbar-toggler">
                                <span class="navbar-toggler-bar bar1"></span>
                                <span class="navbar-toggler-bar bar2"></span>
                                <span class="navbar-toggler-bar bar3"></span>
                            </button>
                        </div>
                        <a class="navbar-brand" href="{{ route('profile.show', Auth::user()->id)}}">Dashboard</a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        @include('includes.dashTopMenu')
                    
                    </div>
                </div>

            </nav>
            <!-- End Navbar -->
            
                @yield('content')
            
            <footer class="footer">
        @include('includes.homeFooter')
    </footer>
        </div>
    </div>
<!--   Core JS Files   -->
<script src="../assets-dashboard/js/core/jquery.min.js"></script>
<script src="../assets-dashboard/js/core/popper.min.js"></script>
<script src="../assets-dashboard/js/core/bootstrap.min.js"></script>
<script src="../assets-dashboard/js/plugins/perfect-scrollbar.jquery.min.js"></script>
<!--  Google Maps Plugin    -->
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> -->
<!-- Chart JS -->
<script src="../assets-dashboard/js/plugins/chartjs.min.js"></script>
<!--  Notifications Plugin    -->
<script src="../assets-dashboard/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
<script src="../assets-dashboard/js/now-ui-dashboard.js?v=1.0.1"></script>
<!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
<script src="../assets-dashboard/demo/demo.js"></script>


  <!-- Google Analytics -->
    <!---->
  <script>
      (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
      function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
      e=o.createElement(i);r=o.getElementsByTagName(i)[0];
      e.src='//www.google-analytics.com/analytics.js';
      r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
      ga('create',"{{ $getInfo->getValue('google_analytic') }}");ga('send','pageview');
    </script>
</body>

</html>
