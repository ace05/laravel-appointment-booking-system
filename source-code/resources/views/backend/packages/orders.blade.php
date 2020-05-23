@extends('backend.layouts.app')
@section('title')
   {{{  __('site_orders') }}}
@endsection
@section('content')
<div class="app-title">
    <h1>
        <i class="icon fa fa-chevron-right"></i> {{{ __('site_orders') }}}
    </h1>
</div>
@include('backend.partials.notifications')
<div class="row">
    <div class="col-md-12">
       <div class="tile">
            <div class="mb-2 card card-body bg-light">
                {!! Form::open(['url' => route('admin.packages.orders'), 'class' => 'form-inline float-right', 'method' => 'get']) !!}
                    <div class="form-group mx-sm-3 mb-2">
                        {!! Form::label('start_date', __('site_start_date')) !!}
                        <div class="input-group from_datepicker_wrapper">
                             {!! Form::text('start_date', empty($start_date) === false ? $start_date : null , ['class' => 'form-control', 'id' => 'from-datepicker', 'readonly' => 'readonly']) !!}
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        @if ($errors->has('start_date'))
                            <div class="form-control-feedback text-danger">
                                {{ $errors->first('start_date') }}
                            </div>
                        @endif
                       
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        {!! Form::label('end_date', __('site_end_date')) !!}
                        <div class="input-group to_datepicker_wrapper">
                             {!! Form::text('end_date', empty($end_date) === false ? $end_date : null, ['class' => 'form-control', 'id' => 'to-datepicker', 'readonly' => 'readonly']) !!}
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        @if ($errors->has('end_date'))
                            <div class="form-control-feedback text-danger">
                                {{ $errors->first('end_date') }}
                            </div>
                        @endif
                    </div>
                     {!! Form::submit(__('site_search'), ['class' => 'btn btn-primary mb-2']) !!}
                {!! Form::close() !!}
            </div>
        @if($orders->count() > 0)
            <div class="table-responsive">
                 <table class="table">
                    <thead>
                       <tr>
                          <th>{{{ __('site_name_text') }}}</th>
                          <th>{{{ __('site_email') }}}</th>
                          <th>{{{ __('site_mobile_number') }}}</th>
                          <th>{{{ __('site_service_provider_or_professional') }}}</th>
                          <th>{{{ __('site_price') }}}</th>
                          <th>{{{ __('site_discount') }}}</th>
                          <th>{{{ __('site_status') }}}</th>
                       </tr>
                    </thead>
                    <tbody>
                            @foreach($orders as $order)
                               <tr>
                                    <td>{{{ $order->user->getName() }}}</td>
                                    <td>{{{ $order->user->email }}}</td>
                                    <td>{{{ $order->user->mobile }}}</td>
                                    <td>
                                        <div>
                                            {{ __('site_package_name') }}:
                                            <a href="{{{ route('site.packages.view', ['slug' => $order->package->slug]) }}}" target="_blank">{{{ $order->package->name }}}</a>
                                        </div>
                                        <div>
                                            <small>
                                                By:<strong>
                                                @if(isProfessional($order->package->user))
                                                    {{{ $order->package->user->getName() }}}
                                                @elseif(isServiceProvider($order->package->user))
                                                    {{{ $order->package->user->serviceProvider->name }}}
                                                @endif</strong>
                                            </small>
                                        </div>
                                        <div>
                                            <small>{{{ __('site_mobile_number') }}}:</small>
                                            <small><strong>{{{ $order->package->user->mobile }}}</strong></small>
                                        </div>
                                        <div>
                                            <small>{{{ __('site_date') }}}:</small>
                                            <small><strong>{{{ $order->created_at }}}</strong></small>
                                        </div>
                                    </td>
                                    <td>{{{ config('settings.site_currency') }}}{{{ $order->price }}}</td>
                                    <td>{{{ config('settings.site_currency') }}}{{{ $order->discount }}}</td>
                                    <td>
                                        @if(empty($order->is_accepted) === false)
                                            <span class="badge badge-primary">
                                                {{{ __('site_accepted') }}}
                                            </span>
                                            <span class="badge badge-success">
                                                {{{ __('site_in_progess') }}}
                                            </span>
                                        @elseif(empty($order->is_cancelled) === false)
                                            <span class="badge badge-danger">
                                                {{{ __('site_cancelled') }}}
                                            </span>
                                        @elseif(empty($order->is_completed) === false)
                                            <span class="badge badge-success">
                                                {{{ __('site_completed') }}}
                                            </span>
                                        @elseif(empty($order->is_accepted) === true)
                                            <span class="badge badge-warning">
                                                {{{ __('site_waiting_for_service_approval') }}}
                                            </span>            
                                        @endif
                                    </td>
                               </tr>
                            @endforeach
                    </tbody>
                 </table>
              </div>
                {{ $orders->appends(request()->except('page'))->render("pagination::bootstrap-4") }}
            @else
                <div class="alert alert-warning">
                    <p>{{{ __('site_no_orders_found') }}}</p>
                </div>
            @endif
       </div>
    </div>
  </div>
@endsection