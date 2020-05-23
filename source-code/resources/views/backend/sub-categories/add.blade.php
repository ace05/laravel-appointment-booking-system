@extends('backend.layouts.app')
@section('title')
   {{{  __('site_service_sub_categories') }}}
@endsection
@section('content')
<div class="app-title">
    <div>
        <h1><i class="icon fa fa-chevron-right"></i> {{{  __('site_service_sub_categories') }}}</h1>
    </div>
</div>
@include('backend.partials.notifications')
<div class="row">
    <div class="col-md-8">
      <div class="tile">
        <div class="tile-body">
            {!! Form::open(['url' => route('admin.subcategories.add'), 'files' => true]) !!}
                <div class="form-group">
                    {!! Form::label('name', __('site_sub_category_name') ,['class' => 'control-label']); !!}
                    {!! Form::text('name',null, ['class' => 'form-control']) !!}
                    @if ($errors->has('name'))
                        <div class="form-control-feedback text-danger">
                            {{ $errors->first('name') }}
                        </div>
                    @endif 
                </div>
                <div class="form-group">
                    {!! Form::label('service_category_id', __('site_category_name') ,['class' => 'control-label']); !!}
                    {!! Form::select('service_category_id', $categories,null, ['class' => 'form-control']) !!}
                    @if ($errors->has('service_category_id'))
                        <div class="form-control-feedback text-danger">
                            {{ $errors->first('service_category_id') }}
                        </div>
                    @endif 
                </div>
                <div class="form-group">
                    {!! Form::label('cover', __('site_category_cover_photo') ,['class' => 'control-label']); !!}
                    {!! Form::file('cover', ['class' => 'form-control']) !!}
                    <small class="form-text text-muted" id="fileHelp">{{{ __('site_category_cover_photo_help') }}}</small>
                    @if ($errors->has('cover'))
                        <div class="form-control-feedback text-danger">
                            {{ $errors->first('cover') }}
                        </div>
                    @endif 
                </div>
                <div class="form-group border-top pt-2">
                    {!! Form::submit(__('site_add'), ['class' => 'btn btn-outline-primary btn-lg']); !!}
                </div>
            {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection