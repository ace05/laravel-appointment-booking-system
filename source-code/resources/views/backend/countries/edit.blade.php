@extends('backend.layouts.app')
@section('title')
   {{{  __('site_countries') }}}
@endsection
@section('content')
<div class="app-title">
    <div>
        <h1><i class="icon fa fa-chevron-right"></i> {{{  __('site_countries') }}} - {{{ $country->country }}}</h1>
    </div>
</div>
@include('backend.partials.notifications')
<div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
            {!! Form::open(['url' => route('admin.countries.edit', ['slug' => $country->id])]) !!}
                <div class="form-group">
                    {!! Form::label('country', __('site_country_name') ,['class' => 'control-label']); !!}
                    {!! Form::text('country', $country->country, ['class' => 'form-control']) !!}
                    @if ($errors->has('country'))
                        <div class="form-control-feedback text-danger">
                            {{ $errors->first('country') }}
                        </div>
                    @endif 
                </div>
                <div class="form-group">
                    {!! Form::label('iso', __('site_country_iso_code') ,['class' => 'control-label']); !!}
                    {!! Form::text('iso', $country->iso, ['class' => 'form-control']) !!}
                    @if ($errors->has('iso'))
                        <div class="form-control-feedback text-danger">
                            {{ $errors->first('iso') }}
                        </div>
                    @endif 
                </div>
                <div class="form-group">
                    {!! Form::label('iso3', __('site_country_iso3_code') ,['class' => 'control-label']); !!}
                    {!! Form::text('iso3', $country->iso3, ['class' => 'form-control']) !!}
                    @if ($errors->has('iso3'))
                        <div class="form-control-feedback text-danger">
                            {{ $errors->first('iso3') }}
                        </div>
                    @endif 
                </div>
                <div class="form-group">
                    {!! Form::label('currency_code', __('site_currency_code') ,['class' => 'control-label']); !!}
                    {!! Form::text('currency_code', $country->currency_code, ['class' => 'form-control']) !!}
                    @if ($errors->has('currency_code'))
                        <div class="form-control-feedback text-danger">
                            {{ $errors->first('currency_code') }}
                        </div>
                    @endif 
                </div>
                <div class="form-group">
                    {!! Form::label('currency_name', __('site_currency_name') ,['class' => 'control-label']); !!}
                    {!! Form::text('currency_name', $country->currency_name, ['class' => 'form-control']) !!}
                    @if ($errors->has('currency_name'))
                        <div class="form-control-feedback text-danger">
                            {{ $errors->first('currency_name') }}
                        </div>
                    @endif 
                </div>
                <div class="form-group">
                    {!! Form::label('phone_prefix', __('site_phone_prefix') ,['class' => 'control-label']); !!}
                    {!! Form::text('phone_prefix', $country->phone_prefix, ['class' => 'form-control']) !!}
                    @if ($errors->has('phone_prefix'))
                        <div class="form-control-feedback text-danger">
                            {{ $errors->first('phone_prefix') }}
                        </div>
                    @endif 
                </div>
                <div class="form-group text-center border-top pt-2">
                    {!! Form::submit(__('site_update'), ['class' => 'btn btn-outline-primary btn-lg']); !!}
                </div>
            {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection