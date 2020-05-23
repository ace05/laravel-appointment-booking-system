@extends('backend.layouts.app')
@section('title')
   {{{  __('site_pages') }}}
@endsection
@section('content')
<div class="app-title">
    <div>
        <h1><i class="icon fa fa-chevron-right"></i> {{{  __('site_edit_page') }}} - {{{ $page->title }}}</h1>
    </div>
</div>
@include('backend.partials.notifications')
<div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
            {!! Form::open(['url' => route('admin.page.edit', ['id' => $page->id])]) !!}
                <div class="form-group">
                    {!! Form::label('title', __('site_title') ,['class' => 'control-label']); !!}
                    {!! Form::text('title', $page->title, ['class' => 'form-control']) !!}
                    @if ($errors->has('title'))
                        <div class="form-control-feedback text-danger">
                            {{ $errors->first('title') }}
                        </div>
                    @endif 
                </div>
                <div class="form-group">
                    {!! Form::label('details', __('site_details') ,['class' => 'control-label']); !!}
                    {!! Form::textarea('details', $page->details, ['class' => 'form-control rich-editor']) !!}
                    @if ($errors->has('details'))
                        <div class="form-control-feedback text-danger">
                            {{ $errors->first('details') }}
                        </div>
                    @endif 
                </div>
                <div class="form-group border-top pt-2">
                    {!! Form::submit(__('site_update'), ['class' => 'btn btn-outline-primary btn-lg']); !!}
                </div>
            {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection