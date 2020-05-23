@extends('backend.layouts.app')
@section('title')
   {{{  __('site_sms_templates') }}}
@endsection
@section('content')
<div class="app-title">
    <h1>
        <i class="icon fa fa-chevron-right"></i> {{{ __('site_sms_templates') }}}
    </h1>
</div>
@include('backend.partials.notifications')
<div class="row">
    <div class="col-md-12">
       <div class="tile">
        @if($templates->count() > 0)
            <div class="table-responsive">
                 <table class="table">
                    <thead>
                       <tr>
                          <th>{{{ __('site_sms_template_name') }}}</th>
                          <th>{{{ __('site_actions') }}}</th>
                       </tr>
                    </thead>
                    <tbody>
                            @foreach($templates as $template)
                               <tr>
                                    <td>{{{ __('site_'.$template->slug) }}}</td>
                                    <td>
                                        <a href="{{{ route('admin.edit.sms.template', ['slug' => $template->slug ]) }}}" class="btn btn-warning">
                                            <i class="fa fa-pencil"></i>
                                            {{{ __('site_edit') }}}
                                        </a>
                                    </td>
                               </tr>
                            @endforeach
                    </tbody>
                 </table>
              </div>
                {{ $templates->render("pagination::bootstrap-4") }}
            @else
                <div class="alert alert-warning">
                    <p>No templates found</p>
                </div>
            @endif
       </div>
    </div>
  </div>
@endsection