@extends('backend.layouts.app')
@section('title')
   {{{  __('site_countries') }}}
@endsection
@section('content')
<div class="app-title">
    <h1>
        <i class="icon fa fa-chevron-right"></i> {{{ __('site_countries') }}}
    </h1>
</div>
@include('backend.partials.notifications')
<div class="row">
    <div class="col-md-12">
       <div class="tile">
        @if($countries->count() > 0)
            <div class="table-responsive">
                 <table class="table">
                    <thead>
                       <tr>
                          <th>{{{ __('site_country_name') }}}</th>
                          <th>{{{ __('site_code') }}}</th>
                          <th>{{{ __('site_currency_code') }}}</th>
                          <th>{{{ __('site_currency_name') }}}</th>
                          <th>{{{ __('site_phone_prefix') }}}</th>
                          <th>{{{ __('site_symbol') }}}</th>
                          <th>{{{ __('site_actions') }}}</th>
                       </tr>
                    </thead>
                    <tbody>
                            @foreach($countries as $country)
                               <tr>
                                    <td>{{{ $country->country }}}</td>
                                    <td>{{{ $country->iso }}}</td>
                                    <td>{{{ $country->currency_code }}}</td>
                                    <td>{{{ $country->currency_name }}}</td>
                                    <td>{{{ $country->phone_prefix }}}</td>
                                    <td>{{{ $country->symbol }}}</td>
                                    <td>
                                        <a href="{{{ route('admin.countries.edit', ['id' => $country->id ]) }}}" class="btn btn-warning">
                                            <i class="fa fa-pencil"></i>
                                            {{{ __('site_edit') }}}
                                        </a>
                                    </td>
                               </tr>
                            @endforeach
                    </tbody>
                 </table>
              </div>
                {{ $countries->render("pagination::bootstrap-4") }}
            @else
                <div class="alert alert-warning">
                    <p>No Countries found</p>
                </div>
            @endif
       </div>
    </div>
  </div>
@endsection