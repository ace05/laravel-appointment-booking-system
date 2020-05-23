@extends('frontend.layouts.app')

@section('title')
   {{{  __('site_service_packages') }}}
@endsection

@section('content')
<section class="py-2">
    <div class="container">
        <div class="card card-signin mt-2">
            <div class="card-body">
                <div class="title-header border-bottom p-2 clearfix">
                    <h3 class="card-title float-left">
                        {{{  __('site_service_packages') }}}
                    </h3>
                    <a href="{{{ route('site.packages.add') }}}" class="btn btn-outline-primary btn-lg float-right">
                        <i class="fa fa-plus"></i> {{{ __('site_add') }}}
                    </a>                    
                </div>
                <div class="row mt-3">
                    @if($packages->count() > 0)
                        @php $i=0; @endphp
                        @foreach($packages as $package)
                            <div class="col-md-4">
                                <div class="card">
                                    <img src="{{{ url(getImagePath($package->cover)) }}}" class="card-img-top img-adjusted">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a href="{{{ route('site.packages.view', ['slug' => $package->slug]) }}}">{{{ $package->name }}}</a>
                                        </h5>
                                        <div class="status">
                                            {{{ __('site_active') }}} : 
                                            @if(empty($package->is_active) === false)
                                                <span class="badge badge-success">{{ __('site_yes')}}</span>
                                            @else
                                                <span class="badge badge-danger">{{ __('site_no')}}</span>
                                            @endif 
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
                                        <div class="status">
                                            <dl>
                                                <dt>{{{ __('site_city') }}}</dt>
                                                <dd>{{ $package->city->name }}</dd>
                                                <dt>{{{ __('site_service_category') }}}</dt>
                                                <dd>{{ $package->profession->name }}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                    <div class="card-footer clearfix">
                                        <h3 class="float-right">
                                            <span class="badge badge-success">
                                                {{{ config('settings.site_currency') }}}
                                                {{{ round($package->price - $package->discount) }}}
                                            </span>
                                            @if(empty($package->discount) === false && $package->discount != '0.00')
                                                <span class="badge">
                                                    <strike>{{{ config('settings.site_currency') }}}{{{ round($package->price) }}}
                                                    </strike>
                                                </span>
                                            @endif
                                        </h3>
                                        <div class="float-left">    
                                            <div class="btn-group dropup">               
                                                <button class="btn btn-outline-primary dropdown-toggle " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{{ __('site_actions')}}}</button>
                                                <div class="dropdown-menu">
                                                  <a class="dropdown-item" href="{{{ route('site.packages.edit', ['slug' => $package->slug]) }}}">{{{ __('site_edit')}}}</a>
                                                    @if(empty($package->is_active) === false)
                                                        <a class="dropdown-item confirmation" href="{{{ route('site.packages.status', ['id' => $package->id, 'status' => 'inactive']) }}}" data-confirm="{{ __('message_are_you_sure') }}">{{ __('site_mark_as_inactive')}}</a>
                                                    @else
                                                        <a class="dropdown-item confirmation" href="{{{ route('site.packages.status', ['id' => $package->id, 'status' => 'active']) }}}" data-confirm="{{ __('message_are_you_sure') }}">{{ __('site_mark_as_active')}}</a>
                                                    @endif

                                                  <a class="dropdown-item" href="{{{ route('site.packages.view', ['slug' => $package->slug]) }}}">{{{ __('site_view') }}}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            @php $i=$i+1; @endphp
                            @if($i%3 === 0)
                                </div>
                                <div class="row mt-3">
                            @endif
                        @endforeach
                        <div class="col-md-12">                            
                            {{ $packages->render("pagination::bootstrap-4") }}
                        </div>
                    @else
                        <div class="alert alert-warning col-md-12 text-center">
                            {{ __('site_no_packages_found') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
