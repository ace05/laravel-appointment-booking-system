@extends('frontend.layouts.app')

@section('title')
   {{{  __('site_register') }}}
@endsection

@section('content')
<section class="py-2">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card card-signin mt-2">
                  <div class="card-body">
                    <h3 class="card-title text-center p-2 border-bottom">
                        {{{  __('site_register') }}}
                    </h3>
                    {!! Form::open(['url' => route('site.register'), 'class' => 'form-signin']) !!}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('first_name', __('site_first_name')) !!}
                                    {!! Form::text('first_name', null, ['class' => $errors->has('first_name') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg', 'placeholder' =>  __('site_first_name')]) !!}
                                    @if ($errors->has('first_name'))
                                        <div class="form-control-feedback text-danger">
                                            {{ $errors->first('first_name') }}
                                        </div>
                                    @endif 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('last_name', __('site_last_name')) !!}
                                    {!! Form::text('last_name', null, ['class' => $errors->has('last_name') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg', 'placeholder' =>  __('site_last_name')]) !!}
                                    @if ($errors->has('last_name'))
                                        <div class="form-control-feedback text-danger">
                                            {{ $errors->first('last_name') }}
                                        </div>
                                    @endif 
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('mobile', __('site_mobile_number')) !!}
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="flag-icon  @if($countryCode)  flag-icon-{{{ strtolower($countryCode) }}}@endif"></i>
                                    </span>
                                </div>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        +{{{ $countryExt }}}
                                    </span>
                                </div>
                                {!! Form::text('mobile_number', null, ['class' => $errors->has('mobile_number') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg', 'placeholder' =>  __('site_mobile_number')]) !!}
                            </div>
                            @if ($errors->has('mobile_number'))
                                <div class="form-control-feedback text-danger">
                                    {{ $errors->first('mobile_number') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            {!! Form::label('email', __('site_email')) !!}
                            {!! Form::text('email', null, ['class' => $errors->has('email') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg', 'placeholder' =>  __('site_email')]) !!}
                            @if ($errors->has('email'))
                                <div class="form-control-email text-danger">
                                    {{ $errors->first('email') }}
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
                            <div class="my-2">
                                {{{ __('site_by_clicking_this_button') }}}.{{{ __('site_you_agree_to_our') }}} <a href="" target="_blank">{{{ __('site_terms_and_conditions') }}}</a>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::submit(__('site_register'), ['class' => 'btn btn-lg btn-outline-primary btn-block']) !!}
                        </div>
                        <div class="my-2">
                            <p>
                                {{{ __('site_already_member') }}} <a href="{{{ route('site.login') }}}">{{{ __('site_login') }}}</a>
                            </p>
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
