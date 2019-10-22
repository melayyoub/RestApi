<html lang="en-US">
@inject('getInfo', 'App\Http\Controllers\AdminsCont')
<!-- {{ $getInfo->getValue('sitename') }} -->
<head>
    @include('includes.homeHeader')
</head>

<body>
    <nav class="navbar navbar-expand-md fixed-top navbar-transparent" color-on-scroll="500">
        <div class="container">
            <div class="navbar-translate">
                <button class="navbar-toggler navbar-toggler-right navbar-burger" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-bar"></span>
                    <span class="navbar-toggler-bar"></span>
                    <span class="navbar-toggler-bar"></span>
                </button>
                <a class="navbar-brand" href="/">{{ $getInfo->getValue('sitename') }}</a>
            </div>
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav ml-auto">
                    @include('includes.topMenu')
                </ul>
            </div>
        </div>
    </nav>
    <div class="wrapper">
        <div class="page-header" height="300"  style="height:300px !important;min-height:300px !important;background-image: url({{ '/'.$post->image }})">
            <img src="/{{ $post->image }}"  id="post-loaded-image" height="300"  style="height:300px !important;min-height:300px !important;background-image: url({{ '/'.$post->image }})">
            <!-- <div class="filter"></div> -->
    		<div class="content-center">
    			<div class="container">
    				<div class="title-brand">
    					<h1 class="presentation-title" style="font-size: 8vmin;">{{ $post->title }}</h1>
    					<div class="fog-low">
    						<img src="/assets/img/fog-low.png" alt="">
    					</div>
    					<div class="fog-low right">
    						<img src="/assets/img/fog-low.png" alt="">
    					</div>
    				</div>
    			</div>
    		</div>
            <div class="moving-clouds" style="background-image: url('/assets/img/clouds.png'); ">

            </div>
    	</div>
        <div class="main">
            <div class="section section-buttons">
                <div class="container">
                    @include('partials._messages')
            @yield('content')
                </div>
            </div>
        </div>
	</div>
    <footer class="footer">
        @include('includes.homeFooter')
    </footer>
</body>

<!-- Core JS Files -->
<script src="/assets/js/jquery-3.2.1.js" type="text/javascript"></script>
<script src="/assets/js/jquery-ui-1.12.1.custom.min.js" type="text/javascript"></script>
<script src="/assets/js/popper.js" type="text/javascript"></script>
<script src="/assets/js/bootstrap.min.js" type="text/javascript"></script>

<!-- Switches -->
<script src="/assets/js/bootstrap-switch.min.js"></script>

<!--  Plugins for Slider -->
<script src="/assets/js/nouislider.js"></script>

<!--  Plugins for DateTimePicker -->
<script src="/assets/js/moment.min.js"></script>
<script src="/assets/js/bootstrap-datetimepicker.min.js"></script>

<!--  Paper Kit Initialization and functons -->
<script src="/assets/js/paper-kit.js?v=2.1.0"></script>

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
</html>
