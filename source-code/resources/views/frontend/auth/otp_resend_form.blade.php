@extends('frontend.layouts.app')

@section('title')
   {{{  __('site_mobile_number_verification') }}}
@endsection

@section('content')
<section class="py-2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card card-signin mt-2">
                      <div class="card-body">
                        <h3 class="card-title text-center p-1">
                            {{{  __('site_mobile_number_verification') }}}
                        </h3>
                        {!! Form::open(['url' => route('site.otp.verify', ['code' => $user->otp_verification_token]), 'class' => 'form-signin']) !!}
                            <div class="form-group">
                                {!! Form::label('mobile', __('site_mobile_number')) !!}
                                (<a href="javascript:void(0)" class="mobile-edit">
                                    <i class="fa fa-pencil"></i> {{{ __('site_edit') }}}
                                </a>)
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
                                     {!! Form::text('mobile', $user->mobile, ['class' => $errors->has('mobile') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg', 'placeholder' =>  __('site_mobile_number'), 'readonly' => 'readonly', 'id' => 'mobile_number']) !!}
                                </div>
                                @if ($errors->has('mobile_number'))
                                    <div class="form-control-feedback text-danger">
                                        {{ $errors->first('mobile_number') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <a href="javascript:void(0)" class="btn btn-outline-primary btn-sm resend-otp" data-url="{{{ route('site.otp.resend', ['code' => $user->otp_verification_token]) }}}">
                                    {{{ __('site_resend_otp') }}}
                                </a>
                            </div>

                            <div class="form-group">
                                {!! Form::label('otp', __('site_enter_otp')) !!}
                                {!! Form::text('otp', null, ['class' => $errors->has('otp') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg', 'placeholder' =>  __('site_enter_otp')]) !!}
                                @if ($errors->has('otp'))
                                    <div class="form-control-feedback text-danger">
                                        {{ $errors->first('otp') }}
                                    </div>
                                @endif 
                            </div>
                            <div class="form-group">
                                {!! Form::submit(__('site_verify_mobile_number'), ['class' => 'btn btn-lg btn-outline-primary btn-block']) !!}
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
