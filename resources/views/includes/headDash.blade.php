<meta charset="utf-8" />
<link rel="apple-touch-icon" sizes="76x76" href="../assets-dashboard/img/apple-icon.png">
<link rel="icon" type="image/png" href="../assets-dashboard/img/favicon.png">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>{{ config('app.name', 'Laravel') }}</title>
<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
<!--     Fonts and icons     -->
<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<link href="//fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
<link href="//use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
<!-- CSS Files -->
<link href="/assets-dashboard/css/bootstrap.min.css" rel="stylesheet" />
<link href="/assets-dashboard/css/now-ui-dashboard.css?v=1.0.1" rel="stylesheet" />
<!-- CSS Just for demo purpose, don't include it in your project -->
<link href="/assets-dashboard/demo/demo.css" rel="stylesheet" />
<!-- Highcharts -->
<script src="//code.highcharts.com/highcharts.js"></script>
<script src="//code.highcharts.com/modules/exporting.js"></script>
<script src="//code.highcharts.com/modules/export-data.js"></script>

<script>
	jQuery(document).ready(function ($){
		$('a#clicktoshow').on('click', function(e){
			e.preventDefault();
			var show = $(this).attr('show');
			$('#'+show).toggle("slow");
			$(this).attr({"aria-expanded":"true"});
		});
		 $(".delete").on("click", function(){
          return confirm("Do you want to delete this item? there's no revert after this step.");
      });
	});

</script>