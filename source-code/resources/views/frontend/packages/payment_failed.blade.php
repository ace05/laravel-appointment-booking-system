@extends('frontend.layouts.app')

@section('title')
   {{{  __('site_payment_failed') }}}
@endsection

@section('content')
<section class="py-2">
    <div class="container">
        <div class="card mt-2">
            <div class="card-body">
                <div class="title-header border-bottom p-2 clearfix">
                    <h3 class="card-title float-left">
                        {{{  __('site_payment_failed') }}}
                    </h3>                  
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <div class="alert alert-warning">
                            <h3>{{{ __('site_payment_failed_msg') }}}. {{{ __('site_order_id') }}}: {{{ strtoupper($id) }}}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
