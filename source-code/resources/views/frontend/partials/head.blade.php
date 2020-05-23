<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@section('title') Home @show | {{{ config('settings.site_name') }}}</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    @if(config('settings.favicon_url'))
    	<link rel="shortcut icon" type="image/png" href="{{{ url(config('settings.favicon_url')) }}}"/>
    @endif
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="description" content="{{{ config('settings.meta_description') }}}"/>
    <meta name="keywords" content="{{{ config('settings.meta_keywords') }}}">
</head>