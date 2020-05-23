@extends('frontend.layouts.app')

@section('title')
   {{{  __('site_update_profession_city_details') }}}
@endsection

@section('content')
<section class="py-2">
    <div class="container">
        <div class="row justify-content-center  mt-2">
            <div class="col-md-8">               
                <div class="card card-signin mt-2">
                    <div class="card-body">
                        <h3 class="card-title text-center p-3 border-bottom">
                            {{{  __('site_update_profession_city_details') }}}
                        </h3>                        
                        {!! Form::open(['url' => route('site.profile.details'), 'files' => true]) !!}
                            @if(isProfessional())
                                <div class="form-group">
                                    {!! Form::label('city_id', __('site_select_city') ,['class' => 'control-label']); !!}
                                    {!! Form::select('city_id', $cities , $selectedCity, ['class' => $errors->has('city_id') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg']) !!}
                                    @if ($errors->has('city_id'))
                                        <div class="form-control-feedback text-danger">
                                            {{ $errors->first('city_id') }}
                                        </div>
                                    @endif 
                                </div>
                                <div class="form-group">
                                    {!! Form::label('profession', __('site_your_primary_profession') ,['class' => 'control-label']); !!}
                                    {!! Form::select('profession', $subCategories ,$selectedProfession, ['class' => $errors->has('city_id') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg']) !!}
                                    @if ($errors->has('profession'))
                                        <div class="form-control-feedback text-danger">
                                            {{ $errors->first('profession') }}
                                        </div>
                                    @endif 
                                </div>
                            @else
                                <div class="form-group">
                                    {!! Form::label('city_id', __('site_select_city') ,['class' => 'control-label']); !!}
                                    {!! Form::select('city_id[]', $cities , $selectedCity, ['class' => $errors->has('city_id') ? 'form-control form-control-lg is-invalid select2' : 'form-control form-control-lg select2','multiple' => 'multiple']) !!}
                                    @if ($errors->has('city_id'))
                                        <div class="form-control-feedback text-danger">
                                            {{ $errors->first('city_id') }}
                                        </div>
                                    @endif 
                                </div>
                                <div class="form-group">
                                    {!! Form::label('profession', __('site_your_primary_profession') ,['class' => 'control-label']); !!}
                                    {!! Form::select('profession[]', $subCategories ,$selectedProfession, ['class' => $errors->has('city_id') ? 'form-control form-control-lg is-invalid select2' : 'form-control form-control-lg select2','multiple' => 'multiple']) !!}
                                    @if ($errors->has('profession'))
                                        <div class="form-control-feedback text-danger">
                                            {{ $errors->first('profession') }}
                                        </div>
                                    @endif 
                                </div>
                            @endif               
                            <div class="form-group">
                                {!! Form::submit(__('site_update'), ['class' => 'btn btn-lg btn-outline-primary btn-block']) !!}
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
