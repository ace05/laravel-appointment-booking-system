@extends('frontend.layouts.app')

@section('title')
   {{{ $package->name }}}
@endsection

@section('content')
<section class="py-2">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card mt-2">
                    <div class="card-body">
                        <div class="title-header border-bottom">
                            <h4 class="card-title">
                                {{{ $package->name }}}
                            </h4>
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
                            <div class="categories py-1">
                                <a href="{{{ route('site.service.listing', ['slug' => $package->profession->slug]) }}}">{{ $package->profession->name }}</a>
                            </div>       
                        </div>
                        <div class="package-desc mt-3">
                            <h5 class="card-title">{{ __('site_package_details') }}</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <img src="{{{ url(getImagePath($package->cover)) }}}" class="img-thumbnail">
                                </div>
                                <div class="col-md-6">
                                    {!! $package->details !!}
                                </div>
                            </div>
                        </div>
                        <hr>
                        @if(empty($package->inclusion) === false)
                            <div class="package-inclusion mt-3">
                                <h5 class="card-title">{{ __('site_package_inclusion_details') }}</h5>
                                {!! $package->inclusion !!}
                            </div>
                            <hr>
                        @endif
                        @if(empty($package->exclusion) === false)
                            <div class="package-inclusion mt-3">
                                <h5 class="card-title">{{ __('site_package_exclusion_details') }}</h5>
                                {!! $package->exclusion !!}
                            </div>
                            <hr>
                        @endif
                        @if(empty($package->conditions) === false)
                            <div class="package-inclusion mt-3">
                                <h5 class="card-title">{{ __('site_package_conditions') }}</h5>
                                {!! $package->conditions !!}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card-body">
                        <div class="title-header border-bottom">
                            <h4 class="card-title">
                                {{{ __('site_reviews') }}}
                            </h4>
                        </div>
                        <div class="review-lists mt-2">
                            @if($reviews->count() > 0)
                                @foreach($reviews as $review)
                                    <div class="media my-2 border-bottom py-3">
                                        <img src="{{{ route('image.manipulation', ['path' =>  getImagePath($review->user->avatar), 'w' => 50, 'h' => 50, 'fit' => 'crop']) }}}" class="mr-3" alt="...">
                                        <div class="media-body">
                                            <h6 class="mt-0">{{{ $review->user->getName() }}}</h6>
                                            @if(empty($review->rating) === false)
                                                @php $limit = 5; @endphp
                                                <div class="star-rating">
                                                    @for($i=1; $i<=5; $i++)
                                                        @if($review->rating >= $i)
                                                            <span class="fa fa-star" data-rating="{{{ $i }}}"></span>
                                                        @else
                                                            <span class="fa fa-star-o" data-rating="{{{ $i }}}"></span>
                                                        @endif
                                                    @endfor
                                                </div>
                                            @endif
                                            {!! normalizeText($review->comments) !!}
                                        </div>
                                    </div>
                                @endforeach
                                <div class="col-md-12">                            
                                    {{ $reviews->render("pagination::bootstrap-4") }}
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    {{ __('site_package_not_yet_reviewed') }}
                                </div>

                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @if(Auth::user() && Auth::user()->id != $package->user_id)
                    <div class="card mt-2">
                        <div class="card-body">
                            {!! Form::open(['url' =>  route('site.create.order', ['slug' => $package->slug])]) !!}
                                <div class="price-section">
                                    <span class="price">
                                        {{{ config('settings.site_currency') }}}
                                        {{{ round($package->price - $package->discount) }}}
                                    </span>
                                    @if(empty($package->discount) === false && $package->discount != '0.00')
                                        <span class="discount">
                                            <strike>{{{ config('settings.site_currency') }}}{{{ round($package->price) }}}
                                            </strike>
                                        </span>
                                    @endif
                                </div>
                                @if(empty($package->is_allow_appointment) === false)
                                    <div class="form-group mb-4">
                                        {!! Form::label('appointment_date', __('site_preferred_appointment_date')) !!}
                                        <div class="input-group datepicker_wrapper">
                                             {!! Form::text('appointment_date', null, ['class' => 'form-control', 'id' => 'appointment']) !!}
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                        @if ($errors->has('appointment_date'))
                                            <div class="form-control-feedback text-danger">
                                                {{ $errors->first('appointment_date') }}
                                            </div>
                                        @endif
                                       
                                    </div>
                                @endif
                                <div class="form-group">
                                    {!! Form::submit( __('site_book_now'), ['class' => 'btn btn-block btn-primary btn-lg']) !!}
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                @endif
                <div class="card card-profile text-center">
                    <div class="card-block">
                        <img alt="" class="card-img-profile" src="{{{ route('image.manipulation', ['path' =>  getImagePath($package->user->avatar), 'w' => 150, 'h' => 150, 'fit' => 'crop']) }}}">
                        <h4 class="card-title">
                            @if(isProfessional($package->user))
                                {{{ $package->user->getName() }}}
                            @elseif(isServiceProvider($package->user))
                                {{{ $package->user->serviceProvider->name }}}
                            @endif
                        </h4>
                    </div>
                </div>
                @if(Auth::user())
                    <div class="card card-profile p-3">
                        <div class="card-block">
                            @if(empty($address) === false)
                                <h5 class="card-title">{{ __('site_contact_details') }}</h5>
                                <div class="address-details">
                                    <address>
                                        <i>
                                            {{{ $address->flat_no }}},
                                            {{{ $address->address_line1 }}},<br>
                                            @if(empty($address->address_line2) === false)
                                                {{ $address->address_line2 }},<br>
                                            @endif
                                            {{ $address->city->name }},<br>
                                            {{ $address->country->country }},<br>
                                            {{ $address->pincode }}
                                        </i>
                                    </address>  
                                </div>
                                <hr>
                            @endif
                            <h5 class="card-title">{{ __('site_about') }} - 
                                @if(isProfessional($package->user))
                                    {{{ $package->user->getName() }}}
                                @elseif(isServiceProvider($package->user))
                                    {{{ $package->user->serviceProvider->name }}}
                                @endif
                            </h5>
                            <div class="about-details">
                                @if(isProfessional($package->user))
                                    {!! normalizeText($package->user->profile->about) !!}
                                @elseif(isServiceProvider($package->user))
                                    {!! normalizeText($package->user->serviceProvider->about) !!}
                                @endif 
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
