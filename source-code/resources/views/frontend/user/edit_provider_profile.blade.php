@extends('frontend.layouts.app')

@section('title')
   {{{  __('site_company_profile_details') }}}
@endsection

@section('content')
<section class="py-2">
    <div class="container">
        <div class="row justify-content-center  mt-2">
            <div class="col-md-8">               
                <div class="card card-signin mt-2">
                    <div class="card-body">
                        <h3 class="card-title text-center p-3 border-bottom">
                            {{{  __('site_company_profile_details') }}}
                        </h3>                        
                        {!! Form::open(['url' => route('site.provider.profile'), 'class' => 'row', 'files' => true]) !!}
                            <div class="col-md-6">
                                <h4>{{{ __('site_service_provider_details') }}}</h4>
                                <hr>
                                 <div class="form-group">
                                    {!! Form::label('name', __('site_service_provider_name')) !!}
                                    {!! Form::text('name', $user->serviceProvider->name, ['class' => $errors->has('name') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg', 'placeholder' =>  __('site_first_name')]) !!}
                                    @if ($errors->has('name'))
                                        <div class="form-control-feedback text-danger">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @endif 
                                </div>
                                <div class="form-group">
                                    {!! Form::label('about', __('site_about_you_and_profession') ,['class' => 'control-label']); !!}
                                    {!! Form::textarea('about' ,empty($user->serviceProvider) === false ? $user->serviceProvider->about : null, ['class' => $errors->has('about') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg', 'rows' => '5']) !!}
                                    @if ($errors->has('about'))
                                        <div class="form-control-feedback text-danger">
                                            {{ $errors->first('about') }}
                                        </div>
                                    @endif 
                                </div>
                                <div class="form-group">
                                    {!! Form::label('avatar', __('site_profile_avatar') ,['class' => 'control-label']); !!}
                                    {!! Form::file('avatar' , ['class' => $errors->has('avatar') ? 'form-control  is-invalid' : 'form-control ']) !!}
                                    @if ($errors->has('avatar'))
                                        <div class="form-control-feedback text-danger">
                                            {{ $errors->first('avatar') }}
                                        </div>
                                    @endif 
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <h4>{{{ __('site_account_details') }}}</h4>
                                <hr>
                                <div class="form-group">
                                    {!! Form::label('first_name', __('site_first_name')) !!}
                                    {!! Form::text('first_name', $user->first_name, ['class' => $errors->has('first_name') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg', 'placeholder' =>  __('site_first_name')]) !!}
                                    @if ($errors->has('first_name'))
                                        <div class="form-control-feedback text-danger">
                                            {{ $errors->first('first_name') }}
                                        </div>
                                    @endif 
                                </div>
                                <div class="form-group">
                                    {!! Form::label('last_name', __('site_last_name')) !!}
                                    {!! Form::text('last_name', $user->last_name, ['class' => $errors->has('last_name') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg', 'placeholder' =>  __('site_last_name')]) !!}
                                    @if ($errors->has('last_name'))
                                        <div class="form-control-feedback text-danger">
                                            {{ $errors->first('last_name') }}
                                        </div>
                                    @endif 
                                </div>
                            </div>
                            <div class="col-md-12">                         
                                <div class="form-group">
                                    {!! Form::submit(__('site_update'), ['class' => 'btn btn-lg btn-outline-primary btn-block']) !!}
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
