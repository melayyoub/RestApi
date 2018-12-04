@inject('getInfo', 'App\Http\Controllers\AdminsCont')
<!-- {{ $getInfo->getValue('sitename') }} -->
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="title" content="{{ $getInfo->getValue('sitename') }}">
    <meta name="description" content="{{ $getInfo->getValue('description') }}">
    <meta name="keywords" content="{{ $getInfo->getValue('main_keywords') }}">
    <meta name="author" content="{{ $getInfo->getValue('powered_by') }}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $getInfo->getValue('sitename') }}</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS     -->
	<link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
	<link href="/assets/css/styles.css" rel="stylesheet"/>

	<!--  CSS for Demo Purpose, don't include it in your project     -->
	<link href="{{ asset('css/demo.css') }}" rel="stylesheet" />

    <!--     Fonts and icons     -->
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,300,700' rel='stylesheet' type='text/css'>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('css/nucleo-icons.css') }}" rel="stylesheet" />