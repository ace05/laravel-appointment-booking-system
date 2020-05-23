@extends('backend.layouts.app')
@section('title')
   {{{  __('site_user_logins') }}}
@endsection
@section('content')
<div class="app-title">
    <h1>
        <i class="icon fa fa-chevron-right"></i> {{{ __('site_user_logins') }}}
    </h1>
</div>
@include('backend.partials.notifications')
<div class="row">
    <div class="col-md-12">
       <div class="tile">
        @if($logins->count() > 0)
            <div class="table-responsive">
                 <table class="table">
                    <thead>
                       <tr>
                          <th>{{{ __('site_name_text') }}}</th>
                          <th>{{{ __('site_email') }}}</th>
                          <th>{{{ __('site_mobile_number') }}}</th>
                          <th>{{{ __('site_date') }}}</th>
                          <th>{{{ __('site_status') }}}</th>
                       </tr>
                    </thead>
                    <tbody>
                            @foreach($logins as $login)
                               <tr>
                                  <td>{{{ $login->user->getName() }}}</td>
                                  <td>{{{ $login->user->email }}}</td>
                                  <td>{{{ $login->user->mobile }}}</td>
                                  <td>{{{ $login->created_at }}}</td>
                                  <td>
                                      
                                      <div>
                                          {{{ __('site_login_user_agent_details') }}}:
                                          <strong>{{{ getBrowser($login->user_agent) }}}</strong>
                                      </div>
                                      <div>
                                          {{{ __('site_ip_address') }}}:
                                          <strong>{{{ $login->ip_address }}}</strong>
                                      </div>
                                  </td>
                               </tr>
                            @endforeach
                    </tbody>
                 </table>
              </div>
                {{ $logins->appends(request()->except('page'))->render("pagination::bootstrap-4") }}
            @else
                <div class="alert alert-warning">
                    <p>{{{ __('site_no_users_found') }}}</p>
                </div>
            @endif
       </div>
    </div>
  </div>
@endsection