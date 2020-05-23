@extends('frontend.layouts.app')

@section('title')
   {{{  __('site_login') }}}
@endsection

@section('content')
<section class="py-2">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card card-signin mt-2">
                  <div class="card-body">
                    <h3 class="card-title text-center p-1 border-bottom p-2">
                        {{{  __('site_login') }}}
                    </h3>
                    {!! Form::open(['url' => route('site.login'), 'class' => 'form-signin']) !!}
                        <div class="form-group">
                            {!! Form::label('login', __('site_login_control')) !!}
                            {!! Form::text('login', null, ['class' => $errors->has('login') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg', 'placeholder' =>  __('site_login_control')]) !!}
                            @if ($errors->has('login'))
                                <div class="form-control-feedback text-danger">
                                    {{ $errors->first('login') }}
                                </div>
                            @endif 
                        </div>

                        <div class="form-group">
                            {!! Form::label('password', __('site_password')) !!}
                            {!! Form::password('password', ['class' => $errors->has('password') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg', 'placeholder' =>  __('site_password')]) !!}
                            @if ($errors->has('password'))
                                <div class="form-control-feedback text-danger">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('site_remember_me') }}
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::submit(__('site_login'), ['class' => 'btn btn-lg btn-outline-primary btn-block']) !!}
                        </div>
                        <div class="form-group">
                            {{{ __('site_new_member') }}} <a href="{{{ route('site.register') }}}">{{{ __('site_register') }}}</a> | 
                            <a href="{{{ route('site.forgot.password') }}}" title="{{{ __('site_forgot_password') }}}">
                                {{{ __('site_forgot_password') }}}?
                            </a>
                        </div>
                        @if(config('settings.facebook_login') == 'Yes')
                            <div class="login-or">
                                <hr class="hr-or">
                                <span class="span-or">or</span>
                            </div>
                            <div>
                                @if(config('settings.facebook_login') == 'Yes')
                                    <a href="{{{ route('site.social.login', ['type' => 'facebook']) }}}" class="btn btn-lg btn-facebook btn-block">
                                        <i class="fa fa-facebook-f"></i>
                                        {{{ __('site_login_using_facebook') }}}
                                    </a> 
                                @endif
                            </div>
                        @endif
                    {!! Form::close() !!}
                  </div>
                </div>
              </div>
        </div>
    </div>
</section>
@endsection
