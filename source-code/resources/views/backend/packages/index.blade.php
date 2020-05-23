@extends('backend.layouts.app')
@section('title')
   {{{  __('site_service_packages') }}}
@endsection
@section('content')
<div class="app-title">
    <h1>
        <i class="icon fa fa-chevron-right"></i> {{{ __('site_service_packages') }}}
    </h1>
</div>
@include('backend.partials.notifications')
<div class="row">
    <div class="col-md-12">
       <div class="tile">
        @if($packages->count() > 0)
            <div class="table-responsive">
                 <table class="table">
                    <thead>
                       <tr>
                          <th>{{{ __('site_name_text') }}}</th>
                          <th>{{{ __('site_email') }}}</th>
                          <th>{{{ __('site_mobile_number') }}}</th>
                          <th>{{{ __('site_price') }}}</th>
                          <th>{{{ __('site_discount') }}}</th>
                          <th>{{{ __('site_status') }}}</th>
                          <th>{{{ __('site_actions') }}}</th>
                       </tr>
                    </thead>
                    <tbody>
                            @foreach($packages as $package)
                               <tr>
                                  <td>
                                    <a href="{{{ route('site.packages.view', ['slug' => $package->slug]) }}}" target="_blank">{{{ $package->name }}}</a> 
                                    <div>
                                        <small>
                                            By:<strong>
                                            @if(isProfessional($package->user))
                                                {{{ $package->user->getName() }}}
                                            @elseif(isServiceProvider($package->user))
                                                {{{ $package->user->serviceProvider->name }}}
                                            @endif</strong>
                                        </small>
                                    </div>
                                  </td>
                                  <td>{{{ $package->user->email }}}</td>
                                  <td>{{{ $package->user->mobile }}}</td>
                                  <td>{{{ config('settings.site_currency') }}}{{{ $package->price }}}</td>
                                  <td>{{{ config('settings.site_currency') }}}{{{ $package->discount }}}</td>
                                  <td>
                                        <div>
                                            {{{ __('site_active') }}} : 
                                            @if(empty($package->is_active) === false)
                                                <span class="badge badge-success">{{ __('site_yes')}}</span>
                                            @else
                                                <span class="badge badge-danger">{{ __('site_no')}}</span>
                                            @endif
                                        </div>
                                        <div>
                                            {{{ __('site_approval_status') }}} : 
                                            @if(empty($package->is_approved) === true)
                                                <p>
                                                    <span class="badge badge-warning">{{{ __('site_waiting_for_admin_approval') }}}</span>
                                                </p>
                                            @else
                                                <p>
                                                    <span class="badge badge-success">{{{ __('site_approved') }}}</span>
                                                </p>
                                            @endif
                                        </div>
                                        <div>
                                              {{{ __('site_date') }}}:
                                              <strong>{{{ $package->created_at }}}</strong>
                                          </div>
                                  </td>
                                  <td>
                                      <div class="btn-group">
                                        <button class="btn btn-outline-primary dropdown-toggle " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{{ __('site_actions')}}}</button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item confirmation" href="{{ route('admin.packages.status', ['id' => $package->id, 'type' => 'approve']) }}" data-confirm="{{ __('message_are_you_sure') }}">   {{{ __('site_approve')}}}
                                            </a>
                                            <a class="dropdown-item confirmation" href="{{ route('admin.packages.status', ['id' => $package->id, 'type' => 'un-approve']) }}" data-confirm="{{ __('message_are_you_sure') }}">   {{{ __('site_unapprove')}}}
                                            </a>
                                        </div>
                                    </div>
                                  </td>
                               </tr>
                            @endforeach
                    </tbody>
                 </table>
              </div>
                {{ $packages->appends(request()->except('page'))->render("pagination::bootstrap-4") }}
            @else
                <div class="alert alert-warning">
                    <p>{{{ __('site_no_packages_found') }}}</p>
                </div>
            @endif
       </div>
    </div>
  </div>
@endsection