@extends('backend.layouts.app')
@section('title')
   {{{  __('site_cities') }}}
@endsection
@section('content')
<div class="app-title">
    <h1>
        <i class="icon fa fa-chevron-right"></i> {{{ __('site_cities') }}}
    </h1>
    <a href="{{{ route('admin.city.add') }}}" class="btn btn-lg btn-primary">
        <i class="fa fa-plus"></i>{{{ __('site_add') }}}
    </a>
</div>
@include('backend.partials.notifications')
<div class="row">
    <div class="col-md-12">
       <div class="tile">
        @if($cities->count() > 0)
            <div class="table-responsive">
                 <table class="table">
                    <thead>
                       <tr>
                          <th>{{{ __('site_city_name') }}}</th>
                          <th>{{{ __('site_country_name') }}}</th>
                          <th>{{{ __('site_is_active') }}}</th>
                          <th>{{{ __('site_actions') }}}</th>
                       </tr>
                    </thead>
                    <tbody>
                            @foreach($cities as $city)
                               <tr>
                                    <td>{{{ $city->name }}}</td>
                                    <td>{{{ $city->country->country }}}</td>
                                    <td>
                                        @if(empty($city->is_active) === false)
                                            <span class="badge badge-success">{{{ __('site_yes') }}}</span>
                                        @else
                                            <span class="badge badge-danger">{{{ __('site_no') }}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{{ route('admin.cities.edit', ['id' => $city->id ]) }}}" class="btn btn-warning">
                                            <i class="fa fa-pencil"></i>
                                            {{{ __('site_edit') }}}
                                        </a>
                                        <a href="{{{ route('admin.cities.delete', ['id' => $city->id ]) }}}" data-confirm="{{ __('message_are_you_sure') }}" class="confirmation btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                           {{{ __('site_delete') }}}
                                        </a>
                                        @if($city->is_active)
                                             <a href="{{{ route('admin.cities.disable', ['id' => $city->id ]) }}}" data-confirm="{{ __('message_are_you_sure') }}" class="confirmation btn btn-info">
                                                <i class="fa fa-times"></i>
                                               {{{ __('site_disable') }}}
                                            </a>
                                        @else
                                            <a href="{{{ route('admin.cities.enable', ['id' => $city->id ]) }}}" data-confirm="{{ __('message_are_you_sure') }}" class="confirmation btn btn-success">
                                                <i class="fa fa-check"></i>
                                               {{{ __('site_enable') }}}
                                            </a>
                                        @endif
                                    </td>
                               </tr>
                            @endforeach
                    </tbody>
                 </table>
              </div>
                {{ $cities->render("pagination::bootstrap-4") }}
            @else
                <div class="alert alert-warning">
                    <p>No Cities found</p>
                </div>
            @endif
       </div>
    </div>
  </div>
@endsection