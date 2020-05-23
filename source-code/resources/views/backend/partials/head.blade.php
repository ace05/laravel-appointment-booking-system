<head>
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<title>@section('title') Login @show | {{{ config('settings.site_name') }}} Admin</title>
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />

	<link rel="stylesheet" href="{{ url(elixir('css/admin.css')) }}" />
	@section('page_styles')@show
	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>