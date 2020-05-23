@extends('backend.layouts.app')
@section('title')
   {{{  __('site_service_providers') }}}
@endsection
@section('content')
<div class="app-title">
    <h1>
        <i class="icon fa fa-chevron-right"></i> {{{ __('site_service_providers') }}}
    </h1>
</div>
@include('backend.partials.notifications')
<div class="row">
    <div class="col-md-12">
       <div class="tile">
        <div class="clearfix">
            {!! Form::open(['url' => route('admin.providers.list'), 'class' => 'form-inline float-right', 'method' => 'get']) !!}
                <div class="form-group mx-sm-3 mb-2">
                    {!! Form::text('search',  empty(request()->get('search')) === false ? request()->get('search') : null, ['class' => 'form-control', 'placeholder' => __('site_email_or_mobile_number')]) !!}
                </div>
                {!! Form::submit(__('site_search'), ['class' => 'btn btn-primary mb-2']) !!}
            {!! Form::close() !!}
        </div>
        @if($serviceProviders->count() > 0)
            <div class="table-responsive">
                 <table class="table">
                    <thead>
                       <tr>
                          <th>{{{ __('site_name_text') }}}</th>
                          <th>{{{ __('site_email') }}}</th>
                          <th>{{{ __('site_mobile_number') }}}</th>
                          <th>{{{ __('site_status') }}}</th>
                          <th>{{{ __('site_available_balance') }}}</th>
                          <th>{{{ __('site_actions') }}}</th>
                       </tr>
                    </thead>
                    <tbody>
                            @foreach($serviceProviders as $provider)
                               <tr>
                                  <td>{{{ $provider->serviceProvider->name }}}</td>
                                  <td>{{{ $provider->email }}}</td>
                                  <td>{{{ $provider->mobile }}}</td>
                                  <td>
                                      <div>
                                          {{{ __('site_email_verified') }}}:
                                          @if(empty($provider->is_email_verified) === false)
                                            <span class="badge badge-success">{{{ __('site_yes') }}}</span>
                                          @else
                                            <span class="badge badge-danger">{{{ __('site_no') }}}</span>
                                          @endif
                                      </div>
                                      <div>
                                          {{{ __('site_mobile_verified') }}}:
                                          @if(empty($provider->is_mobile_verified) === false)
                                            <span class="badge badge-success">{{{ __('site_yes') }}}</span>
                                          @else
                                            <span class="badge badge-danger">{{{ __('site_no') }}}</span>
                                          @endif
                                      </div>
                                      <div>
                                          {{{ __('site_account_blocked') }}}:
                                          @if(empty($provider->is_blocked) === false)
                                            <span class="badge badge-danger">{{{ __('site_yes') }}}</span>
                                          @else
                                            <span class="badge badge-success">{{{ __('site_no') }}}</span>
                                          @endif
                                      </div>
                                      <div>
                                          {{{ __('site_registered_user_agent_details') }}}:
                                          <strong>{{{ getBrowser($provider->user_agent) }}}</strong>
                                      </div>
                                      <div>
                                          {{{ __('site_registered_date') }}}:
                                          <strong>{{{ $provider->created_at }}}</strong>
                                      </div>
                                  </td>
                                  <td>{{{ config('settings.site_currency') }}}{{{ $provider->available_balance }}}</td>
                                  <td>
                                      <div class="btn-group">
                                        <button class="btn btn-outline-primary dropdown-toggle " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{{ __('site_actions')}}}</button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item confirmation" href="{{ route('admin.providers.status', ['id' => $provider->id, 'type' => 'block']) }}" data-confirm="{{ __('message_are_you_sure') }}">   {{{ __('site_block')}}}
                                            </a>
                                            <a class="dropdown-item confirmation" href="{{ route('admin.providers.status', ['id' => $provider->id, 'type' => 'unblock']) }}" data-confirm="{{ __('message_are_you_sure') }}">   {{{ __('site_unblock')}}}
                                            </a>
                                            <a class="dropdown-item confirmation" href="{{ route('admin.providers.status', ['id' => $provider->id, 'type' => 'email-verified']) }}" data-confirm="{{ __('message_are_you_sure') }}">   {{{ __('site_email_verified')}}}
                                            </a>
                                            <a class="dropdown-item confirmation" href="{{ route('admin.providers.status', ['id' => $provider->id, 'type' => 'mobile-verified']) }}" data-confirm="{{ __('message_are_you_sure') }}">   {{{ __('site_mobile_verified')}}}
                                            </a>
                                        </div>
                                    </div>
                                  </td>
                               </tr>
                            @endforeach
                    </tbody>
                 </table>
              </div>
                {{ $serviceProviders->appends(request()->except('page'))->render("pagination::bootstrap-4") }}
            @else
                <div class="alert alert-warning">
                    <p>{{{ __('site_no_providers_found') }}}</p>
                </div>
            @endif
       </div>
    </div>
  </div>
@endsection