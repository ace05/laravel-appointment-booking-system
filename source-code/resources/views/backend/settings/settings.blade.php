@extends('backend.layouts.app')
@section('title')
   {{{  __('site_settings') }}}
@endsection
@section('content')
<div class="app-title">
    <div>
        <h1><i class="icon fa fa-chevron-right"></i> {{{ __('site_'.$settingCategory->slug) }}}</h1>
    </div>
</div>
@include('backend.partials.notifications')
<div class="row">
    <div class="col-md-8">
      <div class="tile">
        <div class="tile-body">
            {!! Form::open(['url' => route('admin.settings', ['slug' => $settingCategory->slug]), 'files' => true]) !!}
                @if(empty($settingCategory->settings) === false)
                    @foreach($settingCategory->settings as $setting)
                        <div class="form-group">
                            {!! Form::label($setting->trans_key, __('site_'.$setting->trans_key) ,['class' => 'control-label']); !!}
                            @if($setting->type === 'text')
                                    {!! Form::text($setting->trans_key, $setting->value,['class' => 'form-control']) !!}
                            @elseif($setting->type === 'upload')
                                    {!! Form::file($setting->trans_key,['class' => 'form-control']) !!}
                            @elseif($setting->type === 'select')
                                    {!! Form::select($setting->trans_key, formAdminSelectOption($setting->inputs), $setting->value, ['class' => 'form-control']) !!}
                            @elseif($setting->type === 'database')
                                    {!! Form::select($setting->trans_key, getDataFromDatabase($setting->inputs), $setting->value, ['class' => 'form-control']) !!}
                            @elseif($setting->type === 'textarea')
                                    {!! Form::textarea($setting->trans_key, $setting->value, ['class' => 'form-control']) !!}
                            @endif
                            @if(empty($setting->help) === false)
                                <small id="{{{$setting->trans_key}}}Help" class="form-text text-muted">{{{ $setting->help }}}</small>
                            @endif

                            @if($setting->type === 'upload' && empty($setting->value) === false)
                                <div class="mt-1">
                                    <img src="{{{ url($setting->value) }}}" class="img-thumbnail">                           
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
                <div class="form-group">
                    {!! Form::submit(__('site_update'), ['class' => 'btn btn-outline-primary btn-lg']); !!}
                </div>
            {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection