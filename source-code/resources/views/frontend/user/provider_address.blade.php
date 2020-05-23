@extends('frontend.layouts.app')

@section('title')
   {{{  __('site_address_details') }}}
@endsection

@section('content')
<section class="py-2">
    <div class="container">
        <div class="card mt-2">
            <div class="card-body">
                <div class="title-header border-bottom p-2 clearfix">
                    <h3 class="card-title float-left">
                        {{{  __('site_address_details') }}}
                    </h3>
                    <a href="{{{ route('site.provider.address.add') }}}" class="btn btn-outline-primary btn-lg float-right">
                        <i class="fa fa-plus"></i> {{{ __('site_add') }}}
                    </a>                    
                </div>
                <div class="row mt-3">
                    @if($addresses->count() > 0)
                        @php $i=0; @endphp
                        @foreach($addresses as $address)
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
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
                                    <div class="card-footer">
                                        <a href="{{{ route('site.provider.address.edit', ['id' => $address->id]) }}}" class="btn btn-outline-primary">{{ __('site_edit') }}
                                        </a>
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
                            {{ $addresses->render("pagination::bootstrap-4") }}
                        </div>
                    @else
                        <div class="alert alert-warning col-md-12 text-center">
                            {{ __('site_no_address_found') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
