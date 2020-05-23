@extends('backend.layouts.app')
@section('title')
   {{{  __('site_add_translation') }}}
@endsection
@section('content')
<div class="app-title">
    <div>
        <h1><i class="icon fa fa-chevron-right"></i> {{{  __('site_add_translation') }}}</h1>
    </div>
</div>
@include('backend.partials.notifications')
<div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
            {!! Form::open(['url' => route('admin.translation.add')]) !!}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('language_name') ? 'has-danger' : '' }}">
                            {!! Form::label('language_name', __('site_language_name') ,['class' => 'control-label']); !!}
                            {!! Form::text('language_name', null,['class' => $errors->has('language_name') ? 'form-control is-invalid' : 'form-control']) !!}
                            @if ($errors->has('language_name'))
                                <div class="form-control-feedback text-danger">
                                    {{ $errors->first('language_name') }}
                                </div>
                            @endif                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('language_code') ? 'has-danger' : '' }}">
                            {!! Form::label('language_code', __('site_language_code') ,['class' => 'control-label']); !!}
                            {!! Form::text('language_code', null,['class' => $errors->has('language_code') ? 'form-control is-invalid' : 'form-control']) !!}
                            @if ($errors->has('language_code'))
                                <div class="form-control-feedback text-danger">
                                    {{ $errors->first('language_code') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @if(empty($transKeys) === false)
                    <div class="table-responsive border-top my-3">
                       <table class="table">
                          <thead>
                             <tr>
                                <th>{{{ __('site_translation_key') }}}</th>
                                <th>{{{ __('site_translation_value') }}}</th>
                             </tr>
                          </thead>
                          <tbody>
                            @foreach($transKeys as $key => $keyValue)
                                 <tr>
                                    <td>{!! Form::label($key, $key ,['class' => 'control-label']); !!}</td>
                                    <td>
                                        {!! Form::textarea($key, $keyValue,['class' => 'form-control', 'rows' => 2]) !!}
                                    </td>
                                 </tr>
                            @endforeach
                          </tbody>
                       </table>
                    </div>
                    
                @endif
                <div class="form-group text-center border-top pt-2">
                    {!! Form::submit(__('site_add'), ['class' => 'btn btn-outline-primary btn-lg']); !!}
                </div>
            {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection