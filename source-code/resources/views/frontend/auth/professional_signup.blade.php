@extends('frontend.layouts.app')

@section('title')
   {{{  __('site_register_as_professional') }}}
@endsection

@section('content')
<section class="py-2">
    <div class="container">
        <div class="row">
            <div class="col-md-8">               
                <div class="card card-signin mt-2">
                    <div class="card-body">
                        <h3 class="card-title text-center p-3 border-bottom">
                            {{{  __('site_register_as_professional') }}}
                        </h3>                        
                        {!! Form::open(['url' => route('site.professional.register'), 'class' => 'row']) !!}
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
                                <div class="form-group">
                                    {!! Form::label('last_name', __('site_last_name')) !!}
                                    {!! Form::text('last_name', null, ['class' => $errors->has('last_name') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg', 'placeholder' =>  __('site_last_name')]) !!}
                                    @if ($errors->has('last_name'))
                                        <div class="form-control-feedback text-danger">
                                            {{ $errors->first('last_name') }}
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
                                    {!! Form::label('gender', __('site_gender')) !!}
                                    {!! Form::select('gender', genders(), null, ['class' => $errors->has('gender') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg']) !!}
                                    @if ($errors->has('gender'))
                                        <div class="form-control-feedback text-danger">
                                            {{ $errors->first('gender') }}
                                        </div>
                                    @endif 
                                </div>
                            </div>
                            <div class="col-md-6">
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
                                    {!! Form::label('city_id', __('site_select_city') ,['class' => 'control-label']); !!}
                                    {!! Form::select('city_id', $cities ,null, ['class' => $errors->has('city_id') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg']) !!}
                                    @if ($errors->has('city_id'))
                                        <div class="form-control-feedback text-danger">
                                            {{ $errors->first('city_id') }}
                                        </div>
                                    @endif 
                                </div>
                                <div class="form-group">
                                    {!! Form::label('profession', __('site_your_primary_profession') ,['class' => 'control-label']); !!}
                                    {!! Form::select('profession', $subCategories ,null, ['class' => $errors->has('city_id') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg']) !!}
                                    @if ($errors->has('profession'))
                                        <div class="form-control-feedback text-danger">
                                            {{ $errors->first('profession') }}
                                        </div>
                                    @endif 
                                </div>
                                <div class="form-group">
                                    {!! Form::label('about', __('site_about_you_and_profession') ,['class' => 'control-label']); !!}
                                    {!! Form::textarea('about' ,null, ['class' => $errors->has('about') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg', 'rows' => '5']) !!}
                                    @if ($errors->has('about'))
                                        <div class="form-control-feedback text-danger">
                                            {{ $errors->first('about') }}
                                        </div>
                                    @endif 
                                </div>
                            </div>
                            <div class="col-md-12">    
                                 <div class="form-group">
                                    <div class="my-2">
                                        {{{ __('site_by_clicking_this_button') }}}.{{{ __('site_you_agree_to_our') }}} <a href="" target="_blank">{{{ __('site_terms_and_conditions') }}}</a>
                                    </div>
                                </div>                            
                                <div class="form-group">
                                    {!! Form::submit(__('site_register'), ['class' => 'btn btn-lg btn-outline-primary btn-block']) !!}
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="benifits-section text-center">
                    <div>               
                        <div class="card text-center mt-2">
                            <div class="card-body">
                                <i class="fa fa-usd fa-3x" aria-hidden="true"></i>
                                <div class="title">
                                    <h4>{{{ __('site_grow_your_business') }}}</h4>
                                </div>
                                <div class="text">
                                   <p>{{{ __('site_grow_your_business_slogan') }}}</p>
                                </div>                                
                            </div>
                        </div>               
                        <div class="card text-center mt-2">
                            <div class="card-body">
                                <i class="fa fa-user-plus fa-3x" aria-hidden="true"></i>
                                <div class="title">
                                    <h4>{{{ __('site_work_on_your_own_terms') }}}</h4>
                                </div>
                                <div class="text">
                                   <p>{{{ __('site_work_on_your_own_terms_slogan') }}}</p>
                                </div>                                
                            </div>
                        </div>               
                        <div class="card text-center mt-2">
                            <div class="card-body">
                                <i class="fa fa-clipboard fa-3x" aria-hidden="true"></i>
                                <div class="title">
                                    <h4>{{{ __('site_business_tools') }}}</h4>
                                </div>
                                <div class="text">
                                   <p>{{{ __('site_business_tools_slogan') }}}</p>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
