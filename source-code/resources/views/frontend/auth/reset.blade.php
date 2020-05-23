@extends('frontend.layouts.app')

@section('title')
   {{{  __('site_reset_password') }}}
@endsection

@section('content')
<section class="py-2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card card-signin mt-2">
                      <div class="card-body">
                        <h3 class="card-title text-center p-1">
                            {{{  __('site_reset_password') }}}
                        </h3>
                        {!! Form::open(['url' => route('password.update'), 'class' => 'form-signin']) !!}
                            <div class="form-group">
                                {!! Form::label('email', __('site_email')) !!}
                                {!! Form::text('email', null, ['class' => $errors->has('email') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg', 'placeholder' =>  __('site_email')]) !!}
                                @if ($errors->has('email'))
                                    <div class="form-control-feedback text-danger">
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
                        {!! Form::hidden('token', $token) !!}
                        <div class="form-group">
                            {!! Form::label('password_confirmation', __('site_confirm_password')) !!}
                            {!! Form::password('password_confirmation', ['class' => $errors->has('password_confirmation') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg', 'placeholder' =>  __('site_confirm_password')]) !!}
                            @if ($errors->has('password_confirmation'))
                                <div class="form-control-feedback text-danger">
                                    {{ $errors->first('password_confirmation') }}
                                </div>
                            @endif 
                        </div>
                            <div class="form-group">
                                {!! Form::submit(__('site_reset_password'), ['class' => 'btn btn-lg btn-outline-primary btn-block']) !!}
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

