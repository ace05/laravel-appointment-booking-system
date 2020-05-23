@extends('backend.layouts.app')
@section('title')
    {{{ __('site_dashboard') }}}
@endsection

@section('content')
<div class="app-title">
    <div>
      	<h1><i class="fa fa-dashboard"></i> {{{ __('site_dashboard') }}}</h1>
    </div>
</div>
<div class="row">
   <div class="col-md-6 col-lg-3">
      <div class="widget-small primary coloured-icon">
         <i class="icon fa fa-users fa-3x"></i>
         <div class="info">
            <h4>{{{ __('site_users') }}}</h4>
            <p><b>{{{ $usersCount}}}</b></p>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-lg-3">
      <div class="widget-small info coloured-icon">
         <i class="icon fa fa-cubes fa-3x"></i>
         <div class="info">
            <h4>{{{ __('site_service_packages') }}}</h4>
            <p><b>{{{ $packagesCount}}}</b></p>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-lg-3">
      <div class="widget-small warning coloured-icon">
         <i class="icon fa fa-shopping-cart fa-3x"></i>
         <div class="info">
            <h4>{{{ __('site_orders') }}}</h4>
            <p><b>{{{ $ordersCount}}}</b></p>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-lg-3">
      <div class="widget-small danger coloured-icon">
         <i class="icon fa fa-money fa-3x"></i>
         <div class="info">
            <h4>{{{ __('site_revenues') }}}</h4>
            <p><b>{{{ config('settings.site_currency') }}}{{{ $earnings}}}</b></p>
         </div>
      </div>
   </div>
   <div class="d-none revenue-trends">
   	  	{{{ json_encode($revenueTrends) }}}
   </div>
   <div class="d-none orders-trends">
   	  	{{{ json_encode($orderTrends) }}}
   </div>
   
</div>
<div class="row">
	<div class="col-md-12">
		<div class="tile">
	    	<h3 class="tile-title">{{{ __('site_last_6_months_revenue_and_sales') }}}</h3>
	    	<div class="embed-responsive embed-responsive-16by9" style="height:40vh;">
	      		<canvas class="embed-responsive-item" id="lineChartDemo"></canvas>
	    	</div>
		</div>
	</div>
</div>
@endsection
