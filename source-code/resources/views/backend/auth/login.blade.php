@extends('backend.layouts.auth')
@section('title')
    {{{ config('settings.site_name') }}} {{{ __('admin_login') }}}
@endsection

@section('content')

   <section class="login-content">
       @include('backend.partials.notifications')
      <div class="logo">
            @if(config('settings.logo'))
                <img src="{{{ url(config('settings.logo')) }}}" />
            @else
                <h1>{{{ config('settings.site_name') }}} {{{ __('admin_login') }}}</h1>
            @endif
      </div>
      <div class="login-box">

            {!! Form::open(['url' => route('admin.login'), 'method' => 'post', 'class' =>'login-form']) !!}
                <h3 class="login-head">
                    {{{ __('site_login') }}}
                </h3>
                <div class="form-group {{ $errors->has('email') ? 'has-danger' : '' }}">
                    {!! Form::label('email', __('site_email')) !!}
                    {!! Form::text('email', null, ['class' => $errors->has('email') ? 'is-invalid form-control' : 'form-control', 'placeholder' => 'Email']) !!}
                    @if ($errors->has('email'))
                        <div class="form-control-feedback text-danger">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('password') ? 'has-danger' : '' }}">
                    {!! Form::label('password', 'Password') !!}
                    {!! Form::password('password', ['class' => $errors->has('password') ? 'form-control is-invalid' : 'form-control', 'placeholder' => 'Password']) !!}
                    @if ($errors->has('password'))
                        <div class="form-control-feedback text-danger">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                   <div class="utility">
                        <div class="animated-checkbox">
                            <label class="remember">
                               {!! Form::checkbox('remember', true, true, ['id' => 'remember']) !!}
                               <span class="label-text">{{{ __('site_stay_signed_in') }}}</span>
                            </label>
                        </div>
                        <p class="semibold-text mb-2">
                            <a href="{{{ route('site.forgot.password') }}}" data-toggle="flip">{{{ __('site_forgot_password') }}} ?</a>
                        </p>
                   </div>
                </div>
                <div class="form-group btn-container">
                    {!! Form::submit(__('site_login'), ['class' => 'btn btn-primary btn-block']) !!}
                </div>
                <div class="text-center mt-1">                    
                    <a class="btn" href="{{{ url('/') }}}">{{{ __('site_go_to_website') }}}</a>
                </div>
            {!! Form::close() !!}
        </div>
   </section>
@endsection