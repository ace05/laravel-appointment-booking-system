@extends('backend.layouts.app')
@section('title')
   {{{  __('site_translation') }}}
@endsection
@section('content')
<div class="app-title">
    <div>
        <h1><i class="icon fa fa-chevron-right"></i> {{{  __('site_translation') }}} - {{{ $translation->name }}}</h1>
    </div>
</div>
@include('backend.partials.notifications')
<div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
            {!! Form::open(['url' => route('admin.translation.edit', ['id' => $translation->id]), 'files' => true]) !!}
                @if(empty($transKeys) === false)
                    <div class="table-responsive">
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
                    {!! Form::submit(__('site_update'), ['class' => 'btn btn-outline-primary btn-lg']); !!}
                </div>
            {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection