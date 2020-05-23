@extends('frontend.layouts.app')
@section('title')
    {{{ __('site_home') }}}
@endsection
@section('content')
<section class="py-4 home-background">
    <div class="container text-center">
        <div class="intro-text p-3">
            <div class="intro-lead-in">{{{ __('site_your_service_expert') }}} 
                @if(empty($cityLists[$selected_city]) === false) 
                    {{{ __('site_in') }}} {{{ $cityLists[$selected_city] }}}
                @endif
            </div>
            <div class="intro-heading">{{{ __('site_home_page_slogan') }}}</div>
        </div>
        <div class="search-form mb-5">
            <div class="row">
                <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                    <form>
                        <div class="form-row">
                            <div class="col-12 col-md-12 mb-2 mb-md-0">
                                <input type="text" class="form-control form-control-lg service-search" data-url="{{{ route('site.service.search') }}}" placeholder="{{{ __('site_search_placeholder') }}}">
                                <p>{{ __('site_search_help') }}</p>
                            </div>
                        </div>
                    </form>
                </div>                    
            </div>
        </div>
    </div>
</section>
<section class="py-4">
    <div class="container home-category">
        @if($categories->count() > 0)
            @foreach($categories as $category)
                <div class="title py-2 border-bottom">
                    <h4>{{{ $category->name }}}</h4>
                </div>
                @if($category->subCategories->count() > 0)
                    <div class="row mt-2">
                        @foreach($category->subCategories as $subCategory)
                            <div class="col-md-3">
                               <div class="card">
                                    <img src="{{{ url($subCategory->cover) }}}" class="card-img-top img-adjusted">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a href="{{{ route('site.service.listing', ['slug' => $subCategory->slug]) }}}">{{{ $subCategory->name }}}</a>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        @endforeach             
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</section>
@endsection
