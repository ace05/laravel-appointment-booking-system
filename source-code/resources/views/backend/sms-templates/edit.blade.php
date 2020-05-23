@extends('backend.layouts.app')
@section('title')
   {{{  __('site_sms_templates') }}}
@endsection
@section('content')
<div class="app-title">
    <div>
        <h1><i class="icon fa fa-chevron-right"></i> {{{  __('site_sms_templates') }}} - {{{ $template->name }}}</h1>
    </div>
</div>
@include('backend.partials.notifications')
<div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
            {!! Form::open(['url' => route('admin.edit.sms.template', ['slug' => $template->slug])]) !!}
                <div class="form-group">
                    {!! Form::label('tags', __('site_personalised_tags') ,['class' => 'control-label']); !!}
                    <pre>{{{ $template->tags  }}}</pre>
                </div>
                <div class="form-group">
                    {!! Form::label('template', __('site_email_template') ,['class' => 'control-label']); !!}
                    {!! Form::textarea('template', $template->template, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group text-center border-top pt-2">
                    {!! Form::submit(__('site_update'), ['class' => 'btn btn-outline-primary btn-lg']); !!}
                </div>
            {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection