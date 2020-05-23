@extends('frontend.layouts.app')

@section('title')
   {{{ __('site_checkout') }}} {{{ $order->package->name }}}
@endsection

@section('content')
<section class="py-2">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card mt-2">
                    <div class="card-body">
                        <h5 class="card-title border-bottom py-2">
                            <i class="fa fa-lock"></i> {{{ __('site_checkout') }}} - {{{ $order->package->name }}}
                        </h5>
                        @if(empty($is_address_required) === false)
                            <div class="address">  
                                <div id="form-errors"></div>   
                                {!! Form::open(['url' => route('site.order.address', ['id' => $order->id]), 'class' => 'checkout-address-add']) !!}
                                    <div class="row mt-1">
                                        <div class="col-md-6">                  
                                            <div class="form-group">
                                                {!! Form::label('flat_no', __('site_flat_no') ,['class' => 'control-label']); !!}
                                                {!! Form::text('flat_no', null , ['class' => $errors->has('flat_no') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg']) !!}
                                                @if ($errors->has('flat_no'))
                                                    <div class="form-control-feedback text-danger">
                                                        {{ $errors->first('flat_no') }}
                                                    </div>
                                                @endif 
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('address_line1', __('site_address_line1') ,['class' => 'control-label']); !!}
                                                {!! Form::text('address_line1',  null , ['class' => $errors->has('address_line1') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg']) !!}
                                                @if ($errors->has('address_line1'))
                                                    <div class="form-control-feedback text-danger">
                                                        {{ $errors->first('address_line1') }}
                                                    </div>
                                                @endif 
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('address_line2', __('site_address_line2') ,['class' => 'control-label']); !!}
                                                {!! Form::text('address_line2', null, ['class' => $errors->has('address_line2') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg']) !!}
                                                @if ($errors->has('address_line2'))
                                                    <div class="form-control-feedback text-danger">
                                                        {{ $errors->first('address_line2') }}
                                                    </div>
                                                @endif 
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('city_id', __('site_city') ,['class' => 'control-label']); !!}
                                                {!! Form::select('city_id', $cities, null, ['class' => $errors->has('city_id') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg']) !!}
                                                @if ($errors->has('city_id'))
                                                    <div class="form-control-feedback text-danger">
                                                        {{ $errors->first('city_id') }}
                                                    </div>
                                                @endif 
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('pincode', __('site_pincode') ,['class' => 'control-label']); !!}
                                                {!! Form::text('pincode', null, ['class' => $errors->has('pincode') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg']) !!}
                                                @if ($errors->has('pincode'))
                                                    <div class="form-control-feedback text-danger">
                                                        {{ $errors->first('pincode') }}
                                                    </div>
                                                @endif 
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            {!! Form::submit(__('site_add'), ['class' => 'btn btn-lg btn-outline-primary btn-block']) !!}
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                            <hr>
                        @endif
                        <div class="payment @if(empty($is_address_required) === false) disabledarea @endif">
                            @php $stripFee = round(($order->price - $order->discount)*(config('settings.stripe_trans_fee_percentage')/100) + config('settings.stripe_trans_fee_flat'), 2) @endphp
                            @php  $stripeTotal = round($stripFee + ($order->price - $order->discount), 2) @endphp
                            @php $paypalFee = round(($order->price - $order->discount)*(config('settings.paypal_trans_fee_percentage')/100) + config('settings.paypal_trans_fee_flat'), 2) @endphp
                            @php  $paypalTotal = round($paypalFee + ($order->price - $order->discount), 2) @endphp
                            <h5 class="card-title border-bottom py-2">
                                <i class="fa fa-credit-card"></i> {{{ __('site_payment_method') }}}
                            </h5>
                            <ul class="nav nav-tabs nav-linetriangle">
                                <li class="nav-item border-right-blue-grey border-right-lighten-5">
                                    <a class="nav-link active" href="#stripe-payment" data-toggle="tab" >
                                        <img src="{{{ asset('images/stripe-logo.svg') }}}" class="payment-logo">
                                        <p>+ {{{ config('settings.site_currency') }}}{{{ $stripFee }}} handling fee</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#paypal-payment" data-toggle="tab" >
                                      <img src="{{{ asset('images/paypal.svg') }}}" class="payment-logo">
                                      <p>+ {{{ config('settings.site_currency') }}}{{{ $paypalFee }}} handling fee</p>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content px-1 pt-1">
                                <div role="tabpanel" class="tab-pane active" id="stripe-payment">
                                    <div class="order-summary mt-2">
                                        <ul class="list-group mb-2 card">
                                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                                <div>
                                                    <h6 class="my-0">{{{ $order->package->name }}}</h6>
                                                </div>
                                                <span class="text-muted">
                                                    {{{ config('settings.site_currency') }}}
                                                    {{{ round($order->price - $order->discount) }}}
                                                </span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                                <div>
                                                    <h6 class="my-0">Handling Fee</h6>
                                                </div>
                                                <span class="text-muted">
                                                    {{{ config('settings.site_currency') }}}{{{ $stripFee }}}
                                                </span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="font-medium-3">Total</span>
                                                <strong class="font-medium-3">
                                                    {{{ config('settings.site_currency') }}}{{{ $stripeTotal }}}
                                                </strong>
                                            </li>
                                       </ul>
                                    </div>
                                    <div class="text-center">
                                        <form action="{{{ route('site.order.process', ['id' => $order->id]) }}}" method="POST">
                                            <script
                                              src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                              data-key="{{{ config('settings.stripe_pub_key') }}}"
                                              data-amount="{{{ $stripeTotal*100 }}}"
                                              data-name="{{{ config('settings.site_name') }}}"
                                              data-description="{{{ $order->package->name }}}"
                                              data-image="{{{ url(config('settings.logo')) }}}"
                                              data-locale="auto"
                                              data-email="{{{ Auth::user()->email }}}"
                                              data-zip-code="false">
                                            </script>
                                            <input type="hidden" name="type" value="stripe" />
                                        </form>
                                    </div>
                                    <p class=" text-center"><img src="{{{ asset('images/payment.png') }}}"></p>
                                </div>
                                <div class="tab-pane " id="paypal-payment" role="tabpanel">
                                    <div class="order-summary mt-2">
                                        <ul class="list-group mb-2 card">
                                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                                <div>
                                                    <h6 class="my-0">{{{ $order->package->name }}}</h6>
                                                </div>
                                                <span class="text-muted">
                                                    {{{ config('settings.site_currency') }}}
                                                    {{{ round($order->price - $order->discount) }}}
                                                </span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                                <div>
                                                    <h6 class="my-0">Handling Fee</h6>
                                                </div>
                                                <span class="text-muted">
                                                    {{{ config('settings.site_currency') }}}{{{ $paypalFee }}}
                                                </span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="font-medium-3">Total</span>
                                                <strong class="font-medium-3">
                                                    {{{ config('settings.site_currency') }}}{{{ $paypalTotal }}}
                                                </strong>
                                            </li>
                                       </ul>
                                    </div>
                                    <p class="text-center">
                                        {{{ __('site_paypal_accepts') }}}:  <a href="{{{ route('site.paypal.order.process', ['id' => $order->id]) }}}"> <img src="{{{ asset('images/paypal-payments.svg') }}}" class="payment-logo" /></a>
                                    </p>
                                    <p class="text-center">
                                        <a href="{{{ route('site.paypal.order.process', ['id' => $order->id]) }}}">
                                            <img src="{{{ asset('images/checkout-logo-large.png') }}}" />
                                        </a> 
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mt-2">
                    <div class="card-body">
                        <h5 class="card-title border-bottom py-2">
                            <i class="fa fa-shopping-cart"></i> {{{ __('site_order_details') }}}
                        </h5>
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0">
                                        {{{ $order->package->name }}}
                                    </h6>
                                </div>
                                <span class="text-muted">
                                    {{{ config('settings.site_currency') }}}{{{ round($order->price) }}}
                                </span>
                            </li>
                            @if(empty($order->discount) === false && $order->discount != '0.00')
                                <li class="list-group-item d-flex justify-content-between bg-light">
                                      <div class="text-success">
                                            <h6 class="my-0"> 
                                                {{{ __('site_discount') }}}
                                            </h6>
                                      </div>
                                        <span class="text-success">
                                            -{{{ config('settings.site_currency') }}}
                                            {{{ round($order->discount) }}}
                                        </span>
                                </li>
                            @endif
                            <li class="list-group-item d-flex justify-content-between">
                                <span>{{{ __('site_total') }}}</span>
                                <strong>
                                    {{{ config('settings.site_currency') }}}
                                    {{{ round($order->price - $order->discount) }}}
                                </strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
