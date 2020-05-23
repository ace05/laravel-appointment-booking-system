@extends('frontend.layouts.app')

@section('title')
   {{{  __('site_forgot_password') }}}
@endsection

@section('content')
<section class="py-2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card card-signin mt-2">
                      <div class="card-body">
                        <h3 class="card-title text-center p-1">
                            {{{  __('site_forgot_password') }}}
                        </h3>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        {!! Form::open(['url' => route('password.email'), 'class' => 'form-signin']) !!}
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
                                {!! Form::submit(__('site_send_reset_link'), ['class' => 'btn btn-lg btn-outline-primary btn-block']) !!}
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
