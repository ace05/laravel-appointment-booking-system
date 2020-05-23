@extends('backend.layouts.app')
@section('title')
   {{{  __('site_cities') }}}
@endsection
@section('content')
<div class="app-title">
    <div>
        <h1><i class="icon fa fa-chevron-right"></i> {{{  __('site_add_city') }}}</h1>
    </div>
</div>
@include('backend.partials.notifications')
<div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
            {!! Form::open(['url' => route('admin.city.add')]) !!}
                <div class="form-group">
                    {!! Form::label('country_id', __('site_country_name') ,['class' => 'control-label']); !!}
                    {!! Form::select('country_id', $countries,null, ['class' => 'form-control']) !!}
                    @if ($errors->has('country_id'))
                        <div class="form-control-feedback text-danger">
                            {{ $errors->first('country_id') }}
                        </div>
                    @endif 
                </div>
                <div class="form-group">
                    {!! Form::label('name', __('site_city_name') ,['class' => 'control-label']); !!}
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                    @if ($errors->has('name'))
                        <div class="form-control-feedback text-danger">
                            {{ $errors->first('name') }}
                        </div>
                    @endif 
                </div>
                <div class="form-group text-center border-top pt-2">
                    {!! Form::submit(__('site_add'), ['class' => 'btn btn-outline-primary btn-lg']); !!}
                </div>
            {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection