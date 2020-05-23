@extends('backend.layouts.app')
@section('title')
   {{{  __('site_translation') }}}
@endsection
@section('content')
<div class="app-title">
    <h1>
        <i class="icon fa fa-chevron-right"></i> {{{ __('site_translation') }}}
    </h1>
    <a href="{{{ route('admin.translation.add') }}}" class="btn btn-lg btn-primary">
        <i class="fa fa-plus"></i> {{{ __('site_add') }}}
    </a>
</div>
@include('backend.partials.notifications')
<div class="row">
    <div class="col-md-12">
       <div class="tile">
        @if($translations->count() > 0)
            <div class="table-responsive">
                 <table class="table">
                    <thead>
                       <tr>
                          <th>{{{ __('site_language') }}}</th>
                          <th>{{{ __('site_language_code') }}}</th>
                          <th>{{{ __('site_is_active') }}}</th>
                          <th>{{{ __('site_actions') }}}</th>
                       </tr>
                    </thead>
                    <tbody>
                            @foreach($translations as $trans)
                               <tr>
                                  <td>{{{ $trans->name }}}</td>
                                  <td>{{{ $trans->code }}}</td>
                                  <td>
                                    @if(empty($trans->is_active) === false)
                                        <span class="badge badge-success">{{{ __('site_yes') }}}</span>
                                    @else
                                        <span class="badge badge-danger">{{{ __('site_no') }}}</span>
                                    @endif
                                   </td>
                                    <td>
                                        <a href="{{{ route('admin.translation.edit', ['id' => $trans->id ]) }}}" class="btn btn-warning">
                                            <i class="fa fa-pencil"></i>
                                            {{{ __('site_edit') }}}
                                        </a>
                                        @if($trans->code != 'en')
                                            <a href="{{{ route('admin.translation.delete', ['id' => $trans->id ]) }}}" data-confirm="{{ __('message_are_you_sure') }}" class="confirmation btn btn-danger">
                                                <i class="fa fa-trash"></i>
                                               {{{ __('site_delete') }}}
                                            </a>
                                            @if($trans->is_active)
                                                 <a href="{{{ route('admin.translation.disable', ['id' => $trans->id ]) }}}" data-confirm="{{ __('message_are_you_sure') }}" class="confirmation btn btn-info">
                                                    <i class="fa fa-times"></i>
                                                   {{{ __('site_disable') }}}
                                                </a>
                                            @else
                                                <a href="{{{ route('admin.translation.enable', ['id' => $trans->id ]) }}}" data-confirm="{{ __('message_are_you_sure') }}" class="confirmation btn btn-success">
                                                    <i class="fa fa-check"></i>
                                                   {{{ __('site_enable') }}}
                                                </a>
                                            @endif
                                        @endif
                                    </td>
                               </tr>
                            @endforeach
                    </tbody>
                 </table>
              </div>
                {{ $translations->render("pagination::bootstrap-4") }}
            @else
                <div class="alert alert-warning">
                    <p>No translations found</p>
                </div>
            @endif
       </div>
    </div>
  </div>
@endsection