@extends('backend.layouts.app')
@section('title')
   {{{  __('site_service_categories') }}}
@endsection
@section('content')
<div class="app-title">
    <div>
        <h1><i class="icon fa fa-chevron-right"></i> {{{  __('site_add_service_category') }}}</h1>
    </div>
</div>
@include('backend.partials.notifications')
<div class="row">
    <div class="col-md-8">
      <div class="tile">
        <div class="tile-body">
            {!! Form::open(['url' => route('admin.categories.add'), 'files' => true]) !!}
                <div class="form-group">
                    {!! Form::label('name', __('site_category_name') ,['class' => 'control-label']); !!}
                    {!! Form::text('name',null, ['class' => 'form-control']) !!}
                    @if ($errors->has('name'))
                        <div class="form-control-feedback text-danger">
                            {{ $errors->first('name') }}
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