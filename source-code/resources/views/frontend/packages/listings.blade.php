@extends('frontend.layouts.app')

@section('title')
   {{{  __('site_service_packages') }}}
@endsection

@section('content')
<section class="py-2">
    <div class="container">
        <div class="title-header border-bottom p-2 clearfix">
            <h3 class="float-left">
                {{{  $category->name }}}
            </h3>                   
        </div>
        <div class="row search-results mt-3">                  
            @if($packages->count() > 0)
                @php $i=0; @endphp
                @foreach($packages as $package)
                    <div class="col-md-4">
                        <div class="mb-2 visible-xs">
                            <div class="card">
                                <img src="{{{ url(getImagePath($package->cover)) }}}" class="card-img-top img-adjusted">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="{{{ route('site.packages.view', ['slug' => $package->slug]) }}}">{{{ $package->name }}}</a>
                                    </h5>
                                    @if(empty($package->rating) === false)
                                        @php $limit = 5; @endphp
                                        <div class="star-rating">
                                            @for($i=1; $i<=5; $i++)
                                                @if($package->rating >= $i)
                                                    <span class="fa fa-star" data-rating="{{{ $i }}}"></span>
                                                @else
                                                    <span class="fa fa-star-o" data-rating="{{{ $i }}}"></span>
                                                @endif
                                            @endfor
                                        </div>
                                    @endif
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
                                        <a href="{{{ route('site.packages.view', ['slug' => $package->slug]) }}}" class="btn btn-outline-primary">
                                            {{ __('site_book_now') }}
                                        </a>
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
</section>
@endsection
